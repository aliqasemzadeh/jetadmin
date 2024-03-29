<?php

namespace AliQasemzadeh\JetAdmin\Livewire\Admin\User;

use AliQasemzadeh\JetAdmin\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
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

    public function assign(Permission $permission)
    {
        if(!auth()->user()->can('admin_user_permissions')) {
            return abort(403);
        }
        $this->user->givePermissionTo($permission->name);
        $this->dispatch('admin.user.permissions');
        $this->alert(
            'success',
            __('jetadmin::jetadmin.added')
        );
    }

    public function confirmedDeletePermission()
    {
        if(!auth()->user()->can('admin_user_permissions')) {
            return abort(403);
        }
        $this->user->revokePermissionTo($this->permission->name);
        $this->dispatch('admin.user.permissions');
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

    #[On('admin.user.permissions')]
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
