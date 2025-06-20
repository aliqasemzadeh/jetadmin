<?php

namespace App\Livewire\User\Support\Ticket;

use App\Models\Support\Ticket;
use Livewire\Component;

class View extends Component
{
    public Ticket $ticket;
    public function mount($id): void
    {
        $this->ticket = Ticket::findOrFail($id);
    }
    public function render()
    {
        return view('livewire.user.support.ticket.view');
    }
}
