<?php

namespace AliQasemzadeh\JetAdmin\Livewire\App\Main;

use AliQasemzadeh\JetAdmin\Models\Article;
use AliQasemzadeh\JetAdmin\Models\Carousel;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $displayItems = [];

        if(config('jetadmin.home.display-carousels')) {
            $carousels = Carousel::where('language', app()->getLocale())->orderBy('created_at', 'DESC')->take(config('jetadmin.home.count-carousels'))->get();
            $displayItems = ['carousels' => $carousels];
        }

        if(config('jetadmin.home.display-articles')) {
            $articles = Article::where('language', app()->getLocale())->orderBy('created_at', 'DESC')->take(config('jetadmin.home.count-articles'))->get();
            $displayItems['articles'] = $articles;
        }

        return view('jetadmin::livewire.app.main.index', $displayItems);
    }
}
