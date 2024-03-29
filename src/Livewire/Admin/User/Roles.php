<?php

namespace AliQasemzadeh\JetAdmin\Livewire\Admin\User;

use AliQasemzadeh\JetAdmin\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Roles extends Component
{
    use LivewireAlert;
    public $user;
    public $permission;
    public $search = "";
    protected $updatesQueryString = ['search'];

    protected $listeners = [
        'confirmedDeleteRole',
        'cancelledDeleteRole',
        'deleteSelectedQuery',
        'updateRoleList' => 'render'
    ];

    public function mount(User $user)
    {
        if(!auth()->user()->can('admin_user_roles')) {
            return abort(403);
        }
        $this->user = $user;
    }

    public function deleteRole(Role $role)
    {
        if(!auth()->user()->can('admin_user_roles')) {
            return abort(403);
        }
        $this->confirm(__('jetadmin::jetadmin.are_you_sure'), [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => __('jetadmin::jetadmin.cancel'),
            'onConfirmed' => 'confirmedDeleteRole',
            'onCancelled' => 'cancelledDeleteRole'
        ]);
        $this->role = $role;
    }

    public function assign(Role $role)
    {
        if(!auth()->user()->can('admin_user_roles')) {
            return abort(403);
        }
        $this->user->assignRole($role->name);
        $this->dispatch('admin.user.roles');
        $this->alert(
            'success',
            __('jetadmin::jetadmin.added')
        );
    }

    public function confirmedDeleteRole()
    {
        if(!auth()->user()->can('admin_user_roles')) {
            return abort(403);
        }
        $this->user->removeRole($this->role->name);
        $this->dispatch('admin.user.roles');
        $this->alert(
            'success',
            __('jetadmin::jetadmin.removed')
        );
    }

    public function cancelledDeleteRole()
    {
        $this->alert(
            'success',
            __('jetadmin::jetadmin.cancelled')
        );
    }

    #[On('admin.user.roles')]
    public function render()
    {
        if(!auth()->user()->can('admin_user_roles')) {
            return abort(403);
        }
        if($this->search != "") {
            $roles = Role::where('name', 'like', '%'.$this->search.'%')->get();
        } else {
            $roles = Role::all();

        }
        return view('jetadmin::livewire.admin.user.roles', compact('roles'));
    }
}
