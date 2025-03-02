<?php

namespace App\Livewire\Administrator\UserManagement\User;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use LivewireUI\Modal\ModalComponent;
use Spatie\Permission\Models\Role;

class Roles extends ModalComponent
{
    use WithPagination;
    public User $user;
    public $search;

    public function mount($id)
    {
        $this->user = User::findOrFail($id);
    }

    public function assign(Role $role)
    {
        $this->user->assignRole($role->name);
        $this->dispatch('administrator.user-management.user.roles');
    }

    public function delete(Role $role): void
    {
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
