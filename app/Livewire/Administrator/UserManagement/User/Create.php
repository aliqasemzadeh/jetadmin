<?php

namespace App\Livewire\Administrator\UserManagement\User;

use LivewireUI\Modal\ModalComponent;

class Create extends ModalComponent
{
    public function render()
    {
        return view('livewire.administrator.user-management.user.create');
    }
}
