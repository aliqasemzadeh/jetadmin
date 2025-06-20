<?php

namespace App\Livewire\User\Support\Ticket;

use App\Models\Support\Ticket;
use App\Models\Support\TicketFile;
use App\Models\Support\TicketReplay;
use Carbon\Carbon;
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

    public function replay()
    {
        $this->validate();

        $replay = new \App\Models\Support\TicketReplay();
        $replay->ticket_id = $this->ticket->id;
        $replay->user_id = auth()->user()->id;
        $replay->body = $this->body;
        $replay->ip = request()->ip();
        $replay->save();

        foreach ($this->files as $file) {
            $fileRecord = new \App\Models\Support\TicketFile();
            $fileRecord->title = $file->getClientOriginalName();
            $fileRecord->file = $file->store('ticket_files');
            $fileRecord->ticket_id = $this->ticket->id;
            $fileRecord->ticket_replay_id = $replay->id;
            $fileRecord->user_id = auth()->user()->id;
            $fileRecord->save();
        }

        $this->ticket->updated_at = Carbon::now()->toString();
        $this->ticket->status = 'user';
        $this->ticket->save();

        $this->body = null;
        $this->files = [];
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
