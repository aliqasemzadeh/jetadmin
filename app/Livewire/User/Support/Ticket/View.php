<?php

namespace App\Livewire\User\Support\Ticket;

use App\Models\Support\Ticket;
use App\Models\Support\TicketFile;
use App\Models\Support\TicketReplay;
use Livewire\Component;

class View extends Component
{
    public Ticket $ticket;
    public $body;
    public $replays;
    public $files = [];

    protected $rules = [
        'body' => 'required|string',
        'files.*' => 'file|max:2048|nullable',
    ];

    public function mount($id): void
    {
        $this->ticket = Ticket::findOrFail($id);
        $this->replays = TicketReplay::with(['user', 'files'])->where('ticket_id', $this->ticket->id)->latest()->get();
    }

    public function downloadFile(TicketFile $file)
    {
        if($file->ticket->user_id != auth()->user()->id) {
            abort('405');
        }

        return response()->download(storage_path('/app/'.$file->file));
    }

    public function render()
    {
        return view('livewire.user.support.ticket.view');
    }
}
