<?php

namespace AliQasemzadeh\JetAdmin\Livewire\Admin\User\Team;

use AliQasemzadeh\JetAdmin\Models\Team;
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
