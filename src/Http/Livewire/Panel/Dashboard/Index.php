<?php

namespace AliQasemzadeh\JetAdmin\Http\Livewire\Panel\Dashboard;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('jetadmin::livewire.panel.dashboard.index')->layout('layouts.panel');
    }
}
