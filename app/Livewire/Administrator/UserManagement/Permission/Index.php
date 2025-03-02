<?php

namespace App\Livewire\Administrator\UserManagement\Permission;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $this->authorize('administrator_user_permission_index');
        return view('livewire.administrator.user-management.permission.index');
    }
}
