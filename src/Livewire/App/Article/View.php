<?php

namespace AliQasemzadeh\JetAdmin\Livewire\App\Article;

use AliQasemzadeh\JetAdmin\Models\Article;
use Livewire\Component;

class View extends Component
{
    public $article;

    public function mount(Article $article)
    {
        $this->article = $article;
    }

    public function render()
    {
        return view('jetadmin:livewire.app.article.view');
    }
}
