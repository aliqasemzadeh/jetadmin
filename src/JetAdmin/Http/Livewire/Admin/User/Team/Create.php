<?php

namespace AliQasemzadeh\JetAdmin\Http\Livewire\Admin\User\Team;

use AliQasemzadeh\Models\Team;
use AliQasemzadeh\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Create extends Component
{
    use LivewireAlert;

    public $name;
    public $user_id;
    public $personal;
    public $search = "";
    protected $updatesQueryString = ['search'];

    public function setUser($user_id)
    {
        $this->user_id = $user_id;
        $this->alert(
            'success',
            __('jetadmin::user_selected')
        );
    }

    public function create()
    {
        $this->validate(['name' => 'required', 'personal' => 'required', 'user_id' => 'required']);

        $team = new Team();
        $team->name = $this->name;
        $team->user_id = $this->user_id;
        $team->personal_team = $this->personal;
        $team->save();

        $this->emitTo(\AliQasemzadeh\JetAdmin\Http\Livewire\Admin\User\Team\Index::getName(), 'updateList');
        $this->emit('hideModal');

        $this->alert(
            'success',
            __('jetadmin::created')
        );
    }

    public function render()
    {
        if($this->search != "") {
            $users = User::filter(['search' => $this->search])->get();
        } else {
            $users = [];
        }
        return view('jetadmin::livewire.admin.user.team.create', compact('users'));
    }
}
