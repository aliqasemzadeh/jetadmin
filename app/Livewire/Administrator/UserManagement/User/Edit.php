<?php

namespace App\Livewire\Administrator\UserManagement\User;

use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Livewire\Attributes\On;
use Livewire\Component;

class Edit extends Component
{
    public User $user;
    public $id = '';
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public $created_at = '';

    public function mount($id = null)
    {
        if($id != null) {
            $this->user = User::findOrFail($id);
            $this->name = $this->user->name;
            $this->email = $this->user->email;
            $this->created_at = $this->user->created_at;
        }
    }

    #[On('user-updated.{user.id}')]
    public function refreshUser($id)
    {
        Log::error("Error:".$id);
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->created_at = $this->user->created_at;
    }

    public function edit()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'created_at' => ['required', 'date'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user)],
            'password' => ['nullable', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        if($this->password) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $this->user->update($validated);

        $this->dispatch('pg:eventRefresh-administrator.user-management.user.index');
        Flux::modal('administrator.user-management.user.edit.modal')->close();
    }

    public function render()
    {
        $this->authorize('administrator_user_edit');
        return view('livewire.administrator.user-management.user.edit');
    }
}
