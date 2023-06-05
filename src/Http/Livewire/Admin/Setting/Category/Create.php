<?php

namespace AliQasemzadeh\JetAdmin\Http\Livewire\Admin\Setting\Category;

use AliQasemzadeh\Models\Category;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Create extends Component
{
    use LivewireAlert;
    public $description;
    public $type;
    public $title;
    public $language;

    public function create()
    {
        if(!auth()->user()->can('admin_category_create')) {
            return abort(403);
        }
        $this->validate([
            'title' => ['string', 'required'],
            'type' => 'required',
            'language' => 'required',
            'description' => 'nullable',
        ]);

        $category = new Category();
        $category->title = $this->title;
        $category->type = $this->type;
        $category->language = $this->language;
        $category->description = $this->description;
        $category->save();

        $this->emitTo(\AliQasemzadeh\Http\Livewire\Admin\Setting\Category\Index::getName(), 'updateList');
        $this->emit('hideModal');

        $this->alert('success', __('jetadmin::created'));
    }

    public function render()
    {
        return view('jetadmin::livewire.admin.setting.category.create');
    }
}
