<?php

namespace App\Livewire\Administrator\UserManagement\User;

use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Validation\Rules;

class Create extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function create()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        $this->dispatch('pg:eventRefresh-administrator.user-management.user.table');
        Flux::modal('administrator.user-management.user.create.modal')->close();
    }
    public function render()
    {
        $this->authorize('administrator_user_create');
        return view('livewire.administrator.user-management.user.create');
    }
}
