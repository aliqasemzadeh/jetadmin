<?php

namespace AliQasemzadeh\JetAdmin\Http\Livewire\Admin\User;

use AliQasemzadeh\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Permissions extends Component
{
    use LivewireAlert;
    use AuthorizesRequests;
    public $user;
    public $permission;
    public $search = "";
    protected $updatesQueryString = ['search'];

    protected $listeners = [
        'confirmedDeletePermission',
        'cancelledDeletePermission',
        'deleteSelectedQuery',
        'updatePermissionList' => 'render'
    ];

    public function mount(User $user)
    {
        if(!auth()->user()->can('admin_user_permissions')) {
            return abort(403);
        }
        $this->user = $user;
    }

    public function deletePermission(Permission $permission)
    {
        if(!auth()->user()->can('admin_user_permissions')) {
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

    public function assign(Permission $permission)
    {
        if(!auth()->user()->can('admin_user_permissions')) {
            return abort(403);
        }
        $this->user->givePermissionTo($permission->name);
        $this->emit('updatePermissionList');
        $this->alert(
            'success',
            __('jetadmin::added')
        );
    }

    public function confirmedDeletePermission()
    {
        if(!auth()->user()->can('admin_user_permissions')) {
            return abort(403);
        }
        $this->user->revokePermissionTo($this->permission->name);
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
        if(!auth()->user()->can('admin_user_permissions')) {
            return abort(403);
        }
        if($this->search != "") {
            $permissions = Permission::where('name', 'like', '%'.$this->search.'%')->get();
        } else {
            $permissions = Permission::all();

        }
        return view('jetadmin::livewire.admin.user.permissions', compact('permissions'));
    }
}
