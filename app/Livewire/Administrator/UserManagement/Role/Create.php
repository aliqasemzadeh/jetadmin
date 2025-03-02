<?php

namespace App\Livewire\Administrator\UserManagement\Role;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use LivewireUI\Modal\ModalComponent;
use Spatie\Permission\Models\Role;

class Create extends ModalComponent
{
    public string $name = '';
    public string $guard_name = 'web';

    public function create()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255', 'unique:' . Role::class],
            'guard_name' => ['required', 'string', 'max:255', 'in:web'],
        ]);

        Role::create($validated);

        $this->dispatch('pg:eventRefresh-administrator.user-management.role.index');
        $this->dispatch('closeModal');

    }

    public function render()
    {
        return view('livewire.administrator.user-management.role.create');
    }
}
