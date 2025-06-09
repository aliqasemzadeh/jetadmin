<?php

namespace App\Livewire\Administrator\SettingManagement\Category;

use App\Models\Setting\Category;
use Flux\Flux;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public $categoryId;

    public $oldImage;

    #[Validate('required|string|max:255')]
    public $title = '';

    #[Validate('required|string|max:255')]
    public $type = 'article';

    #[Validate('nullable|string|max:255')]
    public $icon = '';

    #[Validate('nullable|image|max:1024')]
    public $image;

    #[Validate('nullable|string|max:255')]
    public $language = 'en';

    #[Validate('nullable|string')]
    public $description = '';

    #[Validate('nullable|integer')]
    public $sort_order = 1;

    #[\Livewire\Attributes\On('administrator.setting-management.category.edit.assign-data')]
    public function assignData($id)
    {
        $this->categoryId = $id;
        $category = Category::findOrFail($id);

        $this->title = $category->title;
        $this->type = $category->type;
        $this->icon = $category->icon;
        $this->oldImage = $category->image;
        $this->image = null;
        $this->language = $category->language;
        $this->description = $category->description;
        $this->sort_order = $category->sort_order;

        Flux::modal('administrator.setting-management.category.edit.modal')->show();
    }

    public function update()
    {
        $this->validate();

        $category = Category::findOrFail($this->categoryId);

        $imagePath = $this->oldImage;
        if ($this->image) {
            $imagePath = $this->image->store('categories', 'public');
        }

        $category->update([
            'title' => $this->title,
            'type' => $this->type,
            'icon' => $this->icon,
            'image' => $imagePath,
            'language' => $this->language,
            'description' => $this->description,
            'sort_order' => $this->sort_order,
        ]);

        $this->reset(['categoryId', 'title', 'type', 'icon', 'image', 'oldImage', 'language', 'description', 'sort_order']);
        $this->dispatch('pg:eventRefresh-administrator.setting-management.category.table');
        $this->dispatch('modal-hide', ['name' => 'administrator.setting-management.category.edit.modal']);
    }

    public function render()
    {
        return view('livewire.administrator.setting-management.category.edit');
    }
}
