<?php

namespace App\Livewire\Administrator\UserManagement\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use LivewireUI\Modal\ModalComponent;

class Edit extends ModalComponent
{
    public User $user;
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount($id)
    {
        $this->user = User::findOrFail($id);
        $this->name = $this->user->name;
        $this->email = $this->user->email;
    }

    public function edit()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user)],
            'password' => ['nullable', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        if($this->password) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $this->user->update($validated);

        $this->dispatch('pg:eventRefresh-administrator.user-management.user.index');
        $this->dispatch('closeModal');
    }

    public function render()
    {
        return view('livewire.administrator.user-management.user.edit');
    }
}
