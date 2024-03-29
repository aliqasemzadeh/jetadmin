<?php

namespace AliQasemzadeh\JetAdmin\View\Components;

use Illuminate\View\Component;

class PanelLayout extends Component
{

    protected $listeners = ['updateCart' => 'render'];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('jetadmin::layouts.panel');
    }
}
