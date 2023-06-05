<?php

namespace AliQasemzadeh\JetAdmin\Http\Livewire\Admin\User\Team;

use AliQasemzadeh\Models\Team;
use AliQasemzadeh\Models\User;
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


    public function mount(Team $team)
    {
        $this->team = $team;
        $this->name = $team->name;
        $this->user_id = $team->user_id;
        $this->personal = $team->personal_team;

        $this->search = User::findOrFail($this->user_id)->name;

    }

    public function setUser($user_id)
    {
        $this->user_id = $user_id;
        $this->alert(
            'success',
            __('jetadmin::user_selected')
        );
    }

    public function edit()
    {
        $this->validate(['name' => 'required', 'personal' => 'required', 'user_id' => 'required']);

        $this->team->name = $this->name;
        $this->team->user_id = $this->user_id;
        $this->team->personal_team = $this->personal;
        $this->team ->save();

        $this->emitTo(\AliQasemzadeh\JetAdmin\Http\Livewire\Admin\User\Team\Index::getName(), 'updateList');
        $this->emit('hideModal');

        $this->alert(
            'success',
            __('jetadmin::edited')
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
