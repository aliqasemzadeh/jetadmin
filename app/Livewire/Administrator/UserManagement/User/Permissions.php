<?php

namespace App\Livewire\Administrator\UserManagement\User;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class Permissions extends Component
{
    use WithPagination;
    public User $user;
    public $search;

    public function mount($id = 1)
    {
        $this->user = User::findOrFail($id);
    }

    public function assign(Permission $permission)
    {
        $this->user->givePermissionTo($permission->name);
        $this->dispatch('administrator.user-management.user.permissions');
    }

    public function delete(Permission $permission): void
    {
        $this->user->revokePermissionTo($permission->name);
        $this->dispatch('administrator.user-management.user.permissions');
    }

    #[On('administrator.user-management.user.permissions.render')]
    public function render()
    {
        $this->authorize('administrator_user_permissions');
        if($this->search != "") {
            $permissions = Permission::where('name', 'like', '%'.$this->search.'%')->paginate();
        } else {
            $permissions = Permission::paginate();
        }
        return view('livewire.administrator.user-management.user.permissions', compact('permissions'));
    }
}
