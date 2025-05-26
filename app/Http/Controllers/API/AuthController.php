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

/**
 * @group Authentication
 *
 * APIs for managing user authentication
 */
class AuthController extends Controller
{
    /**
     * User login
     *
     * Authenticates a user with email and password.
     *
     * @bodyParam email string required The user's email address. Example: user@example.com
     * @bodyParam password string required The user's password. Example: password123
     * @bodyParam remember boolean optional Remember the user's session. Example: true
     *
     * @response {
     *   "status": "success",
     *   "user": {
     *     "id": 1,
     *     "name": "John Doe",
     *     "email": "user@example.com",
     *     "email_verified_at": "2023-01-01T00:00:00.000000Z",
     *     "created_at": "2023-01-01T00:00:00.000000Z",
     *     "updated_at": "2023-01-01T00:00:00.000000Z"
     *   }
     * }
     *
     * @response status=400 {
     *   "status": "failed",
     *   "errors": {
     *     "email": ["The email field is required."],
     *     "password": ["The password field is required."]
     *   }
     * }
     *
     * @response status=422 {
     *   "message": "These credentials do not match our records.",
     *   "errors": {
     *     "email": ["These credentials do not match our records."]
     *   }
     * }
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

        return response()->json(['status' => 'success', 'token' => auth()->user()->createToken('auth-token')->plainTextToken, 'user' => auth()->user()]);
    }

    /**
     * User registration
     *
     * Registers a new user with the provided information.
     *
     * @bodyParam name string required The user's full name. Example: John Doe
     * @bodyParam email string required The user's email address. Example: user@example.com
     * @bodyParam password string required The user's password (min 8 characters). Example: password123
     * @bodyParam password_confirmation string required Confirmation of the password. Example: password123
     *
     * @response {
     *   "status": "success",
     *   "user": {
     *     "id": 1,
     *     "name": "John Doe",
     *     "email": "user@example.com",
     *     "email_verified_at": null,
     *     "created_at": "2023-01-01T00:00:00.000000Z",
     *     "updated_at": "2023-01-01T00:00:00.000000Z"
     *   }
     * }
     *
     * @response status=400 {
     *   "status": "failed",
     *   "errors": {
     *     "name": ["The name field is required."],
     *     "email": ["The email field is required."],
     *     "password": ["The password field is required."]
     *   }
     * }
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

        $request->merge([
            'password' => Hash::make($request->input('password')),
        ]);

        event(new Registered(($user = User::create($request->all()))));

        Auth::login($user);

        return response()->json(['status' => 'success', 'token' => auth()->user()->createToken('auth-token')->plainTextToken, 'user' => auth()->user()]);
    }

    /**
     * Reset password
     *
     * Resets the user's password using the token received in email.
     *
     * @bodyParam token string required The password reset token received in email. Example: 1234567890abcdef1234567890abcdef
     * @bodyParam email string required The user's email address. Example: user@example.com
     * @bodyParam password string required The new password (min 8 characters). Example: newpassword123
     * @bodyParam password_confirmation string required Confirmation of the new password. Example: newpassword123
     *
     * @response {
     *   "status": "success",
     *   "message": "Your password has been reset!"
     * }
     *
     * @response status=400 {
     *   "status": "failed",
     *   "errors": {
     *     "token": ["The token field is required."],
     *     "email": ["The email field is required."],
     *     "password": ["The password field is required."]
     *   }
     * }
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
     * Forgot password
     *
     * Sends a password reset link to the provided email address.
     *
     * @bodyParam email string required The user's email address. Example: user@example.com
     *
     * @response {
     *   "status": "success",
     *   "message": "A reset link will be sent if the account exists."
     * }
     *
     * @response status=400 {
     *   "status": "failed",
     *   "errors": {
     *     "email": ["The email field is required."]
     *   }
     * }
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
     * Send verification email
     *
     * Sends an email verification notification to the authenticated user.
     * Requires authentication.
     *
     * @authenticated
     *
     * @response {
     *   "status": "success",
     *   "message": "A new verification link has been sent to your email address.",
     *   "user": {
     *     "id": 1,
     *     "name": "John Doe",
     *     "email": "user@example.com",
     *     "email_verified_at": null,
     *     "created_at": "2023-01-01T00:00:00.000000Z",
     *     "updated_at": "2023-01-01T00:00:00.000000Z"
     *   }
     * }
     *
     * @response {
     *   "status": "success",
     *   "message": "Your email is already verified.",
     *   "user": {
     *     "id": 1,
     *     "name": "John Doe",
     *     "email": "user@example.com",
     *     "email_verified_at": "2023-01-01T00:00:00.000000Z",
     *     "created_at": "2023-01-01T00:00:00.000000Z",
     *     "updated_at": "2023-01-01T00:00:00.000000Z"
     *   }
     * }
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
     * Verify email
     *
     * Verifies the user's email address using the verification link.
     * This endpoint is typically accessed via the link sent to the user's email.
     *
     * @urlParam id integer required The user ID. Example: 1
     * @urlParam hash string required The verification hash. Example: 3d8f790388a76279c761ce20
     *
     * @authenticated
     *
     * @response {
     *   "status": "success",
     *   "message": "Your email has been verified.",
     *   "user": {
     *     "id": 1,
     *     "name": "John Doe",
     *     "email": "user@example.com",
     *     "email_verified_at": "2023-01-01T00:00:00.000000Z",
     *     "created_at": "2023-01-01T00:00:00.000000Z",
     *     "updated_at": "2023-01-01T00:00:00.000000Z"
     *   }
     * }
     *
     * @response {
     *   "status": "success",
     *   "message": "Your email is already verified.",
     *   "user": {
     *     "id": 1,
     *     "name": "John Doe",
     *     "email": "user@example.com",
     *     "email_verified_at": "2023-01-01T00:00:00.000000Z",
     *     "created_at": "2023-01-01T00:00:00.000000Z",
     *     "updated_at": "2023-01-01T00:00:00.000000Z"
     *   }
     * }
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
