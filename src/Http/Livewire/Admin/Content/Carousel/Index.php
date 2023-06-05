<?php

namespace AliQasemzadeh\JetAdmin\Http\Livewire\Admin\Content\Carousel;

use AliQasemzadeh\Models\Carousel;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $selectedItems = [];
    public $selectAll = false;

    public $carousel;
    public $search;
    public $perPage = 15;
    public $sortColumn = 'created_at';
    public $sortDirection = 'asc';

    protected $paginationTheme = 'bootstrap';

    protected $queryString = ['search'];

    protected $listeners = [
        'confirmedDeleteCarousel',
        'cancelledDeleteCarousel',
        'deleteSelectedQuery',
        'updateList' => 'render'
    ];

    public function clear()
    {
        $this->search = "";
    }

    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
    }

    public function sortByColumn($column)
    {
        if ($this->sortColumn == $column) {
            $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
        } else {
            $this->reset('sortDirection');
            $this->sortColumn = $column;
        }
    }

    public function delete(Carousel $carousel)
    {
        if(!auth()->user()->can('admin_carousel_delete')) {
            return abort(403);
        }
        $this->confirm(__('jetadmin::are_you_sure'), [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => __('jetadmin::cancel'),
            'onConfirmed' => 'confirmedDeleteCarousel',
            'onCancelled' => 'cancelledDeleteCarousel'
        ]);
        $this->carousel = $carousel;
    }


    public function confirmedDeleteCarousel()
    {
        if(!auth()->user()->can('admin_carousel_delete')) {
            return abort(403);
        }
        $this->carousel->delete();
        $this->emit('updateList');
        $this->alert(
            'success',
            __('jetadmin::removed')
        );
    }

    public function cancelledDeleteCarousel()
    {
        $this->alert(
            'success',
            __('jetadmin::cancelled')
        );
    }

    public function mount()
    {
        $this->search = request()->query('search', $this->search);
    }

    public function updatedSelectAll($value)
    {
        if($value) {
            $this->selectedItems = Carousel::pluck('id')->toArray();
        } else {
            $this->selectedItems = [];
        }

    }

    public function updatedSelectedItems($value)
    {
        if($this->selectAll) {
            $this->selectAll = false;
        }
    }

    public function deleteSelected()
    {
        if(!auth()->user()->can('admin_carousel_delete')) {
            return abort(403);
        }
        $this->confirm(__('jetadmin::are_you_sure'), [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => __('jetadmin::cancel'),
            'onConfirmed' => 'deleteSelectedQuery',
            'onCancelled' => 'cancelledDelete'
        ]);
    }

    public function deleteSelectedQuery()
    {
        if(!auth()->user()->can('admin_carousel_delete')) {
            return abort(403);
        }
        Carousel::query()
            ->whereIn('id', $this->selectedItems)
            ->delete();
        $this->selectedItems = [];
        $this->selectAll = false;

        $this->alert(
            'success',
            __('jetadmin::removed')
        );
    }

    public function render()
    {
        if(!auth()->user()->can('admin_carousel_index')) {
            return abort(403);
        }

        $carousels = Carousel::with(['user'])->filter(['search' => $this->search])->orderBy($this->sortColumn, $this->sortDirection)->paginate($this->perPage);
        return view('jetadmin::livewire.admin.content.carousel.index', compact('carousels'))->layout('layouts.admin');
    }
}
