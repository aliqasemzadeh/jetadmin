<?php

namespace App\Livewire\Administrator\ContentManagement\Faq;

use App\Models\Content\FrequentlyAskedQuestion;
use Flux\Flux;
use Livewire\Component;
use Livewire\Attributes\Validate;

class Create extends Component
{
    #[Validate('required|string')]
    public $question = '';

    #[Validate('required|string')]
    public $answer = '';

    #[Validate('required|string|max:255')]
    public $language = 'en';

    #[Validate('nullable|integer')]
    public $sort_order = 1;

    public function create()
    {
        $this->validate();

        FrequentlyAskedQuestion::create([
            'question' => $this->question,
            'answer' => $this->answer,
            'language' => $this->language,
            'sort_order' => $this->sort_order,
        ]);

        $this->reset(['question', 'answer', 'language', 'sort_order']);
        $this->dispatch('pg:eventRefresh-administrator.content-management.faq.table');
        Flux::modal('administrator.content-management.faq.create.modal')->close();
    }

    public function render()
    {
        return view('livewire.administrator.content-management.faq.create');
    }
}
