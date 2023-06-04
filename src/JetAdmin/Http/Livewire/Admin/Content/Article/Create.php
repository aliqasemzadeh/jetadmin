<?php

namespace AliQasemzadeh\JetAdmin\Http\Livewire\Admin\Content\Article;

use AliQasemzadeh\Models\Article;
use AliQasemzadeh\Models\Category;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    public $description;
    public $body;
    public $category_id;
    public $title;
    public $language;
    public $image;

    protected $listeners = [
        'updateList' => 'render'
    ];

    public function create()
    {
        if(!auth()->user()->can('admin_article_create')) {
            return abort(403);
        }

        $this->validate([
            'title' => ['string', 'required'],
            'category_id' => 'required',
            'language' => 'required',
            'description' => 'nullable',
            'body' => 'nullable',
            'image' => 'required|image',
        ]);

        $article = new Article();
        $article->title = $this->title;
        $article->category_id = $this->category_id;
        $article->user_id = auth()->user()->id;
        $article->body = $this->body;
        $article->language = $this->language;
        $article->description = $this->description;
        $article->save();

        $image = $this->image->store('articles');
        $article->addMedia(storage_path('app/' . $image))->toMediaCollection();

        $this->emitTo(\AliQasemzadeh\Http\Livewire\Admin\Content\Article\Index::getName(), 'updateList');
        $this->emit('hideModal');

        $this->alert('success', __('jetadmin::created'));
    }

    public function render()
    {
        $categories = Category::where('type', 'article')->get();
        return view('jetadmin::livewire.admin.content.article.create', compact('categories'));
    }
}
