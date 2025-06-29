<?php

namespace App\Livewire\Administrator\SupportManagement\Ticket;

use App\Models\Support\Ticket;
use App\Models\Support\TicketFile;
use App\Models\Support\TicketReplay;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class View extends Component
{
    use WithFileUploads;
    public Ticket $ticket;
    public $body;
    public $replays;
    public $files = [];

    public function mount($id): void
    {
        $this->ticket = Ticket::findOrFail($id);
        $this->replays = TicketReplay::with(['user', 'files'])->where('ticket_id', $this->ticket->id)->latest()->get();
    }

    public function replay()
    {
        $this->validate([
            'body' => 'required|string',
            'files.*' => 'file|max:2048|nullable',
        ]);

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
        return view('livewire.administrator.support-management.ticket.view');
    }
}
