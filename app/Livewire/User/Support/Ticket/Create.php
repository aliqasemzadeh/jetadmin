<?php

namespace App\Livewire\User\Support\Ticket;

use App\Models\Setting\Category;
use App\Models\Support\Ticket;
use App\Models\Support\TicketFile;
use App\Models\Support\TicketReplay;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    public $title;
    public $body;
    public $category_id;
    public $files = [];
    public function create()
    {
        $this->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'category_id' => 'required|string',
            'files.*' => 'nullable|file|max:1024',
        ]);

        $ticket = new Ticket();
        $ticket->title = $this->title;
        $ticket->category_id = $this->category_id;
        $ticket->user_id = auth()->user()->id;
        $ticket->ip = request()->ip();
        $ticket->save();

        $replay = new TicketReplay();
        $replay->ticket_id = $ticket->id;
        $replay->user_id = auth()->user()->id;
        $replay->body = $this->body;
        $replay->ip = request()->ip();
        $replay->save();

        foreach ($this->files as $file) {
            $fileRecord = new TicketFile();
            $fileRecord->title = $file->getClientOriginalName();
            $fileRecord->file = $file->store('ticket_files');
            $fileRecord->ticket_id = $ticket->id;
            $fileRecord->ticket_replay_id = $replay->id;
            $fileRecord->user_id = auth()->user()->id;
            $fileRecord->save();
        }

        return redirect()->route('user.support.ticket.view', ['id' => $ticket->id]);
    }

    public function render()
    {
        $categories = Category::where('type', 'ticket')->get();
        return view('livewire.user.support.ticket.create', compact('categories'));
    }
}
