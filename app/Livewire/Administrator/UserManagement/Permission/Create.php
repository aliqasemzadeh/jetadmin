<?php

namespace App\Livewire\Administrator\UserManagement\Permission;

use LivewireUI\Modal\ModalComponent;
use Spatie\Permission\Models\Permission;

class Create extends ModalComponent
{
    public string $name = '';
    public string $guard_name = 'web';

    public function create()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255', 'unique:' . Permission::class],
            'guard_name' => ['required', 'string', 'max:255', 'in:web'],
        ]);

        Permission::create($validated);

        $this->dispatch('pg:eventRefresh-administrator.user-management.permission.index');
        $this->dispatch('closeModal');

    }
    public function render()
    {
        $this->authorize('administrator_user_permission_create');
        return view('livewire.administrator.user-management.permission.create');
    }
}
