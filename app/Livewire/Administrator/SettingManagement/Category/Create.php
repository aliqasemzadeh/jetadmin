<?php

namespace App\Livewire\Administrator\SettingManagement\Category;

use App\Models\Setting\Category;
use Flux\Flux;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

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

    public function create()
    {
        $this->validate();

        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('categories', 'public');
        }

        Category::create([
            'title' => $this->title,
            'type' => $this->type,
            'icon' => $this->icon,
            'image' => $imagePath,
            'language' => $this->language,
            'description' => $this->description,
            'sort_order' => $this->sort_order,
        ]);

        $this->reset(['title', 'type', 'icon', 'image', 'language', 'description', 'sort_order']);
        $this->dispatch('pg:eventRefresh-administrator.setting-management.category.table');
        Flux::modal('administrator.setting-management.category.create.modal')->close();
    }

    public function render()
    {
        return view('livewire.administrator.setting-management.category.create');
    }
}
