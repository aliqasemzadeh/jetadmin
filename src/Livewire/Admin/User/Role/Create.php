<?php

namespace AliQasemzadeh\JetAdmin\Livewire\Admin\User\Role;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Create extends Component
{
    use LivewireAlert;
    public $name;

    public function create()
    {
        if(!auth()->user()->can('admin_roles_create')) {
            return abort(403);
        }

        $this->validate([
            'name' => 'required|string'
        ]);

        Role::create(['name' => $this->name]);

        $this->dispatch('admin.user.role.index');
        $this->dispatch('hideModal');

        $this->alert('success', __('jetadmin::jetadmin.created'));
    }


    public function render()
    {
        if(!auth()->user()->can('admin_roles_create')) {
            return abort(403);
        }

        return view('jetadmin::livewire.admin.user.role.create');
    }
}
