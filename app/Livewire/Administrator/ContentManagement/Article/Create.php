<?php

namespace App\Livewire\Administrator\ContentManagement\Article;

use App\Models\Content\Article;
use App\Models\Setting\Category;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Validate;

class Create extends Component
{
    #[Validate('required|string|max:255')]
    public $title = '';

    #[Validate('nullable|string|max:255')]
    public $pre_title = '';

    #[Validate('required|exists:categories,id')]
    public $category_id = '';

    #[Validate('nullable|string')]
    public $description = '';

    #[Validate('nullable|string')]
    public $body = '';

    #[Validate('required|string|max:255')]
    public $language = 'en';

    #[Validate('nullable|boolean')]
    public $public = true;

    public function create()
    {
        $this->validate();

        Article::create([
            'title' => $this->title,
            'pre_title' => $this->pre_title,
            'category_id' => $this->category_id,
            'user_id' => Auth::user()->id,
            'description' => $this->description,
            'body' => $this->body,
            'language' => $this->language,
            'public' => $this->public,
        ]);

        $this->reset(['title', 'pre_title', 'category_id', 'description', 'body', 'language', 'public']);
        $this->dispatch('pg:eventRefresh-administrator.content-management.article.table');
        Flux::modal('administrator.content-management.article.create.modal')->close();
    }

    public function render()
    {
        $categories = Category::where('type', 'article')->get();

        return view('livewire.administrator.content-management.article.create', [
            'categories' => $categories,
        ]);
    }
}
