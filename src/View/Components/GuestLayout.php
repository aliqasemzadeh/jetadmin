<?php

namespace AliQasemzadeh\JetAdmin\View\Components;

use Illuminate\View\Component;

class GuestLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('jetadmin::layouts.guest');
    }
}
