<?php

namespace App\Livewire\Administrator\SupportManagement\Ticket;

use App\Models\Support\Ticket;
use Livewire\Component;

class View extends Component
{
    public Ticket $ticket;

    public function mount($id)
    {
        $this->ticket = Ticket::findOrFail($id);
    }
    public function render()
    {
        return view('livewire.administrator.support-management.ticket.view');
    }
}
