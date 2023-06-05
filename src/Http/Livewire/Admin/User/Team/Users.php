<?php

namespace AliQasemzadeh\JetAdmin\Http\Livewire\Admin\User\Team;

use AliQasemzadeh\Models\Team;
use Livewire\Component;

class Users extends Component
{
    public $team;
    public function mount(Team $team)
    {
        $this->team = $team;
    }

    public function render()
    {
        return view('jetadmin::livewire.admin.user.team.users');
    }
}
