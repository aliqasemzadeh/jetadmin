<?php

namespace App\Livewire\Administrator\UserManagement\Role;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class Permissions extends Component
{
    use WithPagination;
    public Role $role;
    public $search;

    public function mount($id)
    {
        $this->role = Role::findById($id);
    }

    public function assign(Permission $permission)
    {
        $this->role->givePermissionTo($permission->name);
        $this->dispatch('administrator.user-management.role.permissions');
    }

    public function delete(Permission $permission): void
    {
        $this->role->revokePermissionTo($permission->name);
        $this->dispatch('administrator.user-management.role.permissions');
    }

    #[On('administrator.user-management.role.permissions.render')]
    public function render()
    {
        $this->authorize('administrator_user_role_permissions');
        if($this->search != "") {
            $permissions = Permission::where('name', 'like', '%'.$this->search.'%')->paginate();
        } else {
            $permissions = Permission::paginate();
        }
        return view('livewire.administrator.user-management.role.permissions', compact('permissions'));
    }
}
