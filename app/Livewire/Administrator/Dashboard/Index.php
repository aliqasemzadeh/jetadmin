<?php

namespace App\Livewire\Administrator\Dashboard;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $this->authorize('administrator_dashboard_index');
        return view('livewire.administrator.dashboard.index');
    }
}
