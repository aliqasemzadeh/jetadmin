<?php

namespace App\Livewire\Administrator\UserManagement\Role;

use Livewire\Component;

class Users extends Component
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
        $this->authorize('administrator_user_role_users');
        return view('livewire.administrator.user-management.role.users');
    }
}
