<?php

namespace AliQasemzadeh\JetAdmin\Http\Livewire\Admin\User;

use AliQasemzadeh\Models\User;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Ban extends Component
{
    use LivewireAlert;
    public $user;
    public $comment;
    public $expire;
    public $permanent;

    public function mount($user)
    {
        $this->user = User::findOrFail($user);
    }

    public function ban()
    {
        if($this->permanent) {
            $this->user->ban([
                'expired_at' => null,
                'comment' => $this->comment,
            ]);
        } else {
            $this->user->ban([
                'expired_at' => $this->expire,
                'comment' => $this->comment,
            ]);
        }

        $this->emitTo(\AliQasemzadeh\Http\Livewire\Admin\User\Index::getName(), 'updateList');
        $this->emit('hideModal');

        $this->alert('success', __('jetadmin::banned'));
    }

    public function unban()
    {
        $this->user->unban();

        $this->emitTo(\AliQasemzadeh\JetAdmin\Http\Livewire\Admin\User\Index::getName(), 'updateList');
        $this->emit('hideModal');

        $this->alert('success', __('jetadmin::unbanned'));
    }

    public function render()
    {
        return view('jetadmin::livewire.admin.user.ban');
    }
}
