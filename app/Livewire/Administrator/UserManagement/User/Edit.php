<?php

namespace App\Livewire\Administrator\UserManagement\User;

use App\Models\User;
use LivewireUI\Modal\ModalComponent;

class Edit extends ModalComponent
{
    public User $user;

    public function mount($id)
    {
        $this->user = User::findOrFail($id);
    }

    public function edit()
    {

    }

    public function render()
    {
        return view('livewire.administrator.user-management.user.edit');
    }
}
