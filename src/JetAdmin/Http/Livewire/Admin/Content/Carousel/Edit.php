<?php

namespace AliQasemzadeh\JetAdmin\Http\Livewire\Admin\Content\Carousel;

use AliQasemzadeh\Models\Carousel;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    public $title;
    public $description;
    public $language;
    public $image;
    public $link;

    protected $listeners = [
        'updateList' => 'render'
    ];

    public function mount(Carousel $carousel)
    {
        $this->article = $carousel;

        $this->description = $carousel->description;
        $this->title = $carousel->title;
        $this->language = $carousel->language;
        $this->link = $carousel->link;
    }

    public function edit()
    {
        if(!auth()->user()->can('admin_carousel_edit')) {
            return abort(403);
        }

        $this->validate([
            'title' => ['string', 'required'],
            'language' => 'required',
            'description' => 'nullable',
            'link' => 'nullable',
            'image' => 'required|image',
        ]);

        $carousel = $this->carousel;

        if($this->image) {
            $carousel->clearMediaCollection();
            $image = $this->image->store('carousels');
            $carousel->addMedia(storage_path('app/' . $image))->toMediaCollection();
        }

        $carousel->title = $this->title;
        $carousel->user_id = auth()->user()->id;
        $carousel->language = $this->language;
        $carousel->description = $this->description;
        $carousel->link = $this->link;
        $carousel->save();


        $this->emitTo(\AliQasemzadeh\Http\Livewire\Admin\Content\Carousel\Index::getName(), 'updateList');
        $this->emit('hideModal');

        $this->alert('success', __('jetadmin::created'));
    }

    public function render()
    {
        return view('jetadmin::livewire.admin.content.carousel.edit');
    }
}
