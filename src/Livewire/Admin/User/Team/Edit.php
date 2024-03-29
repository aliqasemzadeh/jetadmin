<?php

namespace AliQasemzadeh\JetAdmin\Livewire\Admin\User\Team;

use AliQasemzadeh\JetAdmin\Models\Team;
use AliQasemzadeh\JetAdmin\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Edit extends Component
{
    use LivewireAlert;

    public $team;
    public $name;
    public $user_id;
    public $personal;
    public $search = "";
    protected $updatesQueryString = ['search'];


    public function mount($team_id)
    {
        $this->team = Team::findOrFail($team_id);
        $this->name = $this->team->name;
        $this->user_id = $this->team->user_id;
        $this->personal = $this->team->personal_team;

        $this->search = User::findOrFail($this->user_id)->name;

    }

    public function setUser($user_id)
    {
        $this->user_id = $user_id;
        $this->alert(
            'success',
            __('jetadmin::jetadmin.user_selected')
        );
    }

    public function edit()
    {
        $this->validate(['name' => 'required', 'personal' => 'required', 'user_id' => 'required']);

        $this->team->name = $this->name;
        $this->team->user_id = $this->user_id;
        $this->team->personal_team = $this->personal;
        $this->team ->save();

        $this->dispatch('admin.user.team.index');
        $this->dispatch('hideModal');

        $this->alert(
            'success',
            __('jetadmin::jetadmin.edited')
        );
    }

    public function render()
    {
        if($this->search != "") {
            $users = User::filter(['search' => $this->search])->get();
        } else {
            $users = [];
        }

        return view('jetadmin::livewire.admin.user.team.edit', compact('users'));
    }
}
