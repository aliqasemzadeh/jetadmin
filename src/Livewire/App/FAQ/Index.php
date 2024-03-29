<?php

namespace AliQasemzadeh\JetAdmin\Livewire\App\FAQ;

use AliQasemzadeh\JetAdmin\Models\FrequentlyAskedQuestion;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $faqs = FrequentlyAskedQuestion::all();
        return view('jetadmin::livewire.app.f-a-q.index', compact('faqs'));
    }
}
