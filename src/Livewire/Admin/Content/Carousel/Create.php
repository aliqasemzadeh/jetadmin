<?php

namespace AliQasemzadeh\JetAdmin\Livewire\Admin\Content\Carousel;

use AliQasemzadeh\JetAdmin\Models\Carousel;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    public $title;
    public $link;
    public $description;
    public $language;
    public $image;

    protected $listeners = [
        'updateList' => 'render'
    ];

    public function create()
    {
        if(!auth()->user()->can('admin_carousel_create')) {
            return abort(403);
        }

        $this->validate([
            'title' => ['string', 'required'],
            'language' => 'required',
            'description' => 'nullable',
            'link' => 'nullable',
            'image' => 'required|image',
        ]);

        $carousel = new Carousel();
        $carousel->title = $this->title;
        $carousel->user_id = auth()->user()->id;
        $carousel->language = $this->language;
        $carousel->link = $this->link;
        $carousel->description = $this->description;
        $carousel->save();

        $image = $this->image->store('carousels');
        $carousel->addMedia(storage_path('app/' . $image))->toMediaCollection();

        $this->dispatchTo(\AliQasemzadeh\JetAdmin\Livewire\Admin\Content\Carousel\Index::getName(), 'updateList');
        $this->dispatch('hideModal');

        $this->alert('success', __('jetadmin::jetadmin.created'));
    }

    public function render()
    {
        return view('jetadmin::livewire.admin.content.carousel.create');
    }
}
