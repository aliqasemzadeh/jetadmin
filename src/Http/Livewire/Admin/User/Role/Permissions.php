<?php

namespace AliQasemzadeh\JetAdmin\Http\Livewire\Admin\User\Role;

use AliQasemzadeh\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
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

        $this->confirm(__('jetadmin::are_you_sure'), [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => __('jetadmin::cancel'),
            'onConfirmed' => 'confirmedDeletePermission',
            'onCancelled' => 'cancelledDeletePermission'
        ]);

        $this->permission = $permission;
    }

    public function mount(Role $role)
    {
        if(!auth()->user()->can('admin_roles_permissions')) {
            return abort(403);
        }

        $this->role = $role;
    }

    public function assign(Permission $permission)
    {
        if(!auth()->user()->can('admin_roles_permissions')) {
            return abort(403);
        }

        $this->role->givePermissionTo($permission->name);
        $this->emit('updatePermissionList');
        $this->alert(
            'success',
            __('jetadmin::added')
        );
    }



    public function confirmedDeletePermission()
    {
        if(!auth()->user()->can('admin_roles_permissions')) {
            return abort(403);
        }

        $this->role->revokePermissionTo($this->permission->name);
        $this->emit('updatePermissionList');
        $this->alert(
            'success',
            __('jetadmin::removed')
        );
    }

    public function cancelledDeletePermission()
    {
        $this->alert(
            'success',
            __('jetadmin::cancelled')
        );
    }

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
