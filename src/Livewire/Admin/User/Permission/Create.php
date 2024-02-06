<?php

namespace AliQasemzadeh\JetAdmin\Livewire\Admin\User\Permission;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Create extends Component
{
    use LivewireAlert;
    public $name;

    public function create()
    {
        if(!auth()->user()->can('admin_permissions_create')) {
            return abort(403);
        }

        $this->validate([
            'name' => 'required|string'
        ]);

        Permission::create(['guard_name' => 'web', 'name' => $this->name]);

        $this->dispatchTo(\AliQasemzadeh\JetAdmin\Livewire\Admin\User\Permission\Index::getName(), 'updateList');
        $this->dispatch('hideModal');

        $this->alert('success', __('bap.created'));
    }

    public function render()
    {
        if(!auth()->user()->can('admin_permissions_create')) {
            return abort(403);
        }
        return view('jetadmin:livewire.admin.user.permission.create');
    }
}
