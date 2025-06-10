<?php

namespace App\Livewire\Administrator\ContentManagement\Article;

use App\Models\Content\Article;
use App\Models\Setting\Category;
use App\Models\User;
use Flux\Flux;
use Livewire\Component;
use Livewire\Attributes\Validate;

class Edit extends Component
{
    public $articleId;

    #[Validate('required|string|max:255')]
    public $title = '';

    #[Validate('nullable|string|max:255')]
    public $pre_title = '';

    #[Validate('required|exists:categories,id')]
    public $category_id = '';

    #[Validate('required|exists:users,id')]
    public $user_id = '';

    #[Validate('nullable|string')]
    public $description = '';

    #[Validate('nullable|string')]
    public $body = '';

    #[Validate('required|string|max:255')]
    public $language = 'en';

    #[Validate('nullable|boolean')]
    public $public = true;

    #[\Livewire\Attributes\On('administrator.content-management.article.edit.assign-data')]
    public function assignData($id)
    {
        $this->articleId = $id;
        $article = Article::findOrFail($id);

        $this->title = $article->title;
        $this->pre_title = $article->pre_title;
        $this->category_id = $article->category_id;
        $this->user_id = $article->user_id;
        $this->description = $article->description;
        $this->body = $article->body;
        $this->language = $article->language;
        $this->public = $article->public;

        Flux::modal('administrator.content-management.article.edit.modal')->show();
    }

    public function update()
    {
        $this->validate();

        $article = Article::findOrFail($this->articleId);

        $article->update([
            'title' => $this->title,
            'pre_title' => $this->pre_title,
            'category_id' => $this->category_id,
            'user_id' => $this->user_id,
            'description' => $this->description,
            'body' => $this->body,
            'language' => $this->language,
            'public' => $this->public,
        ]);

        $this->reset(['articleId', 'title', 'pre_title', 'category_id', 'user_id', 'description', 'body', 'language', 'public']);
        $this->dispatch('pg:eventRefresh-administrator.content-management.article.table');
        Flux::modal('administrator.content-management.article.edit.modal')->close();
    }

    public function render()
    {
        $categories = Category::where('type', 'article')->get();
        $users = User::all();

        return view('livewire.administrator.content-management.article.edit', [
            'categories' => $categories,
            'users' => $users,
        ]);
    }
}
