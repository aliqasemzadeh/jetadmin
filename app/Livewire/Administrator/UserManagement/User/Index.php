<?php

namespace App\Livewire\Administrator\UserManagement\User;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $this->authorize('administrator_user_index');
        return view('livewire.administrator.user-management.user.index');
    }
}
