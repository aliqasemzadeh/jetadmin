<?php

namespace AliQasemzadeh\JetAdmin\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Dashboard extends Component
{
    #[Layout('jetadmin::components.layouts.admin')]
    public function render()
    {
        return view('jetadmin::livewire.admin.dashboard');
    }
}
