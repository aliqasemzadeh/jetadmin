<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.admin.user.index');
    }
}
