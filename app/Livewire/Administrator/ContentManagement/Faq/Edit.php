<?php

namespace App\Livewire\Administrator\ContentManagement\Faq;

use App\Models\Content\FrequentlyAskedQuestion;
use Flux\Flux;
use Livewire\Component;
use Livewire\Attributes\Validate;

class Edit extends Component
{
    public $faqId;

    #[Validate('required|string')]
    public $question = '';

    #[Validate('required|string')]
    public $answer = '';

    #[Validate('required|string|max:255')]
    public $language = 'en';

    #[Validate('nullable|integer')]
    public $sort_order = 1;

    #[\Livewire\Attributes\On('administrator.content-management.faq.edit.assign-data')]
    public function assignData($id)
    {
        $this->faqId = $id;
        $faq = FrequentlyAskedQuestion::findOrFail($id);

        $this->question = $faq->question;
        $this->answer = $faq->answer;
        $this->language = $faq->language;
        $this->sort_order = $faq->sort_order;

        Flux::modal('administrator.content-management.faq.edit.modal')->show();
    }

    public function update()
    {
        $this->validate();

        $faq = FrequentlyAskedQuestion::findOrFail($this->faqId);

        $faq->update([
            'question' => $this->question,
            'answer' => $this->answer,
            'language' => $this->language,
            'sort_order' => $this->sort_order,
        ]);

        $this->reset(['faqId', 'question', 'answer', 'language', 'sort_order']);
        $this->dispatch('pg:eventRefresh-administrator.content-management.faq.table');
        Flux::modal('administrator.content-management.faq.edit.modal')->close();
    }

    public function render()
    {
        return view('livewire.administrator.content-management.faq.edit');
    }
}
