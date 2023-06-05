<?php

namespace AliQasemzadeh\JetAdmin\Http\Livewire\App\Article;

use AliQasemzadeh\JetAdmin\Models\Article;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $articles = Article::with(['user', 'category'])->where('language', app()->getLocale())->paginate(config('jetadmin.per-page'));
        return view('jetadmin::livewire.app.article.index', compact('articles'))->layout('jetadmin:layouts.app');
    }
}
