<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember' => 'nullable|boolean'
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'failed', 'errors' => $validator->errors()], 400);
        }

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        return response()->json(['status' => 'failed', 'user' => auth()->user()]);
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'failed', 'errors' => $validator->errors()], 400);
        }

        $validator['password'] = Hash::make($validator['password']);

        event(new Registered(($user = User::create($validator))));

        Auth::login($user);

        return response()->json(['status' => 'success', 'user' => auth()->user()]);
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'failed', 'errors' => $validator->errors()], 400);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status != Password::PasswordReset) {
            $this->addError('email', __($status));

            return;
        }

        return response()->json(['status' => 'success', 'message' => __($status)]);
    }

    /**
     * Send a password reset link to the provided email address.
     */
    public function forgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'failed', 'errors' => $validator->errors()], 400);
        }

        Password::sendResetLink($request->only('email'));

        return response()->json(['status' => 'success', 'message' => __('A reset link will be sent if the account exists.')]);
    }

    /**
     * Send an email verification notification to the user.
     */
    public function sendVerificationEmail()
    {
        if (Auth::user()->hasVerifiedEmail()) {
            return response()->json(['status' => 'success', 'message' => __('kit.your_email_is_verified'), 'user' => auth()->user()]);
        }

        Auth::user()->sendEmailVerificationNotification();

        return response()->json(['status' => 'success', 'message' => __('kit.new_verification_email_sent'), 'user' => auth()->user()]);
    }

    /**
     * Verify user email request.
     *
     */
    public function verifyEmail(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['status' => 'success', 'message' => __('jetadmin.your_email_is_verified'), 'user' => auth()->user()]);
        }

        if ($request->user()->markEmailAsVerified()) {
            /** @var \Illuminate\Contracts\Auth\MustVerifyEmail $user */
            $user = $request->user();

            event(new Verified($user));
        }

        return response()->json(['status' => 'success', 'message' => __('jetadmin.your_email_got_verified'), 'user' => auth()->user()]);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower(request()->email).'|'.request()->ip());
    }
}
