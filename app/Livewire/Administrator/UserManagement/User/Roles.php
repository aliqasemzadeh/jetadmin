<?php

namespace App\Livewire\Administrator\UserManagement\User;

use App\Models\User;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Roles extends Component
{
    use WithPagination;
    public User $user;
    public $search;

    #[On('administrator.user-management.user.roles.assign-data')]
    public function assignData($id): void
    {
        $this->user = User::findOrFail($id);
        Flux::modal('administrator.user-management.user.roles.modal')->show();
    }

    public function assign(Role $role)
    {
        if (!isset($this->user)) {
            return;
        }
        $this->user->assignRole($role->name);
        $this->dispatch('administrator.user-management.user.roles');
    }

    public function delete(Role $role): void
    {
        if (!isset($this->user)) {
            return;
        }
        $this->user->removeRole($role->name);
        $this->dispatch('administrator.user-management.user.roles');
    }


    #[On('administrator.user-management.user.roles.render')]
    public function render()
    {
        $this->authorize('administrator_user_roles');
        if($this->search != "") {
            $roles = Role::where('name', 'like', '%'.$this->search.'%')->paginate();
        } else {
            $roles = Role::paginate();
        }
        return view('livewire.administrator.user-management.user.roles', compact('roles'));
    }
}
