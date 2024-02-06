<?php

namespace AliQasemzadeh\JetAdmin\Livewire\Admin\User;

use AliQasemzadeh\JetAdmin\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

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

        $this->dispatchTo(\AliQasemzadeh\JetAdmin\Livewire\Admin\User\Index::getName(), 'updateList');
        $this->dispatch('hideModal');

        $this->alert('success', __('bap.banned'));
    }

    public function unban()
    {
        $this->user->unban();

        $this->dispatchTo(\AliQasemzadeh\JetAdmin\Livewire\Admin\User\Index::getName(), 'updateList');
        $this->dispatch('hideModal');

        $this->alert('success', __('bap.unbanned'));
    }

    public function render()
    {
        return view('jetadmin::livewire.admin.user.ban');
    }
}
