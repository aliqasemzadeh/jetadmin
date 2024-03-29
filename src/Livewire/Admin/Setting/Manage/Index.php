<?php

namespace AliQasemzadeh\JetAdmin\Livewire\Admin\Setting\Manage;

use Illuminate\Support\Facades\Artisan;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    use LivewireAlert;

    public function turn_on()
    {
        Artisan::call("up");
        $this->alert('success', __('jetadmin::jetadmin.system_turned_on'));
    }

    public function turn_off()
    {
        Artisan::call("down");
        $this->alert('success', __('jetadmin::jetadmin.system_turned_off'));
    }

    #[On('admin.setting.manage.index')]
    public function render()
    {
        return view('jetadmin::livewire.admin.setting.manage.index')->layout('layouts.admin');
    }
}
