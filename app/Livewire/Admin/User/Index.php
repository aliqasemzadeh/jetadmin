<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public function render()
    {
        $users = User::paginate(config('jetadmin.per_page'));
        return view('livewire.admin.user.index', compact('users'));
    }
}
