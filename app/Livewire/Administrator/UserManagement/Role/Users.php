<?php

namespace App\Livewire\Administrator\UserManagement\Role;

use LivewireUI\Modal\ModalComponent;

class Users extends ModalComponent
{
    public \Spatie\Permission\Models\Role $role;
    public function mount($id)
    {
        $this->role = \Spatie\Permission\Models\Role::findById($id);
    }

    public function revoke($id, $name)
    {
        $selected_user = \App\Models\User::findOrFail($id);
        $selected_user->removeRole($name);
    }

    public function render()
    {
        return view('livewire.administrator.user-management.role.users');
    }
}
