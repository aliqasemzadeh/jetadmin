<?php

namespace AliQasemzadeh\JetAdmin\Livewire\Admin\Content\FAQ;

use AliQasemzadeh\JetAdmin\Models\FrequentlyAskedQuestion;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Create extends Component
{
    use LivewireAlert;
    public $question;
    public $answer;

    public function create()
    {
        if(!auth()->user()->can('admin_faq_create')) {
            return abort(403);
        }
        $this->validate([
            'question' => ['string', 'required'],
            'answer' => ['string', 'required'],
        ]);

        $faq = new FrequentlyAskedQuestion();
        $faq->question = $this->question;
        $faq->answer = $this->answer;
        $faq->save();

        $this->dispatchTo(\AliQasemzadeh\JetAdmin\Livewire\Admin\Content\FAQ\Index::getName(), 'updateList');
        $this->dispatch('hideModal');

        $this->alert('success', __('jetadmin::jetadmin.created'));
    }


    public function render()
    {
        return view('jetadmin::livewire.admin.content.f-a-q.create');
    }
}
