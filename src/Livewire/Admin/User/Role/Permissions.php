<?php

namespace AliQasemzadeh\JetAdmin\Livewire\Admin\User\Role;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Permissions extends Component
{
    use LivewireAlert;
    public $role;
    public $permission;
    public $search = "";
    protected $updatesQueryString = ['search'];

    protected $listeners = [
        'confirmedDeletePermission',
        'cancelledDeletePermission',
        'deleteSelectedQuery',
        'updatePermissionList' => 'render'
    ];

    public function deletePermission(Permission $permission)
    {
        if(!auth()->user()->can('admin_roles_permissions')) {
            return abort(403);
        }

        $this->confirm(__('jetadmin::jetadmin.are_you_sure'), [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => __('jetadmin::jetadmin.cancel'),
            'onConfirmed' => 'confirmedDeletePermission',
            'onCancelled' => 'cancelledDeletePermission'
        ]);

        $this->permission = $permission;
    }

    public function mount($role_id)
    {
        if(!auth()->user()->can('admin_roles_permissions')) {
            return abort(403);
        }

        $this->role = Role::findOrFail($role_id);
    }

    public function assign(Permission $permission)
    {
        if(!auth()->user()->can('admin_roles_permissions')) {
            return abort(403);
        }

        $this->role->givePermissionTo($permission->name);
        $this->dispatch('updatePermissionList');
        $this->alert(
            'success',
            __('jetadmin::jetadmin.added')
        );
    }



    public function confirmedDeletePermission()
    {
        if(!auth()->user()->can('admin_roles_permissions')) {
            return abort(403);
        }

        $this->role->revokePermissionTo($this->permission->name);
        $this->dispatch('updatePermissionList');
        $this->alert(
            'success',
            __('jetadmin::jetadmin.removed')
        );
    }

    public function cancelledDeletePermission()
    {
        $this->alert(
            'success',
            __('jetadmin::jetadmin.cancelled')
        );
    }

    #[On('admin.user.role.permissions')]
    public function render()
    {
        if(!auth()->user()->can('admin_roles_permissions')) {
            return abort(403);
        }

        if($this->search != "") {
            $permissions = Permission::where('name', 'like', '%'.$this->search.'%')->get();
        } else {
            $permissions = Permission::all();
        }

        return view('jetadmin::livewire.admin.user.role.permissions', compact('permissions'));
    }
}
