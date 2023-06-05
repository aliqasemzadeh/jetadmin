<?php

namespace AliQasemzadeh\JetAdmin\Http\Livewire\Admin\User\Permission;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class Index extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $selectedItems = [];
    public $selectAll = false;

    public $permission;
    public $search;
    public $perPage = 15;
    public $sortColumn = 'created_at';
    public $sortDirection = 'asc';

    protected $paginationTheme = 'bootstrap';

    protected $queryString = ['search'];

    protected $listeners = [
        'confirmedDelete',
        'cancelledDelete',
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
    public function delete(Permission $permission)
    {
        if(!auth()->user()->can('admin_permissions_delete')) {
            return abort(403);
        }

        $this->confirm(__('jetadmin::are_you_sure'), [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => __('jetadmin::cancel'),
            'onConfirmed' => 'confirmedDelete',
            'onCancelled' => 'cancelledDelete'
        ]);
        $this->permission = $permission;
    }

    public function confirmedDelete()
    {
        if(!auth()->user()->can('admin_permissions_delete')) {
            return abort(403);
        }

        $this->permission->delete();
        $this->emit('updateList');
        $this->alert(
            'success',
            __('jetadmin::removed')
        );
    }

    public function cancelledDelete()
    {
        $this->alert(
            'success',
            __('jetadmin::cancelled')
        );
    }

    public function mount()
    {
        if(!auth()->user()->can('admin_permissions_index')) {
            return abort(403);
        }

        $this->search = request()->query('search', $this->search);
    }

    public function updatedSelectAll($value)
    {
        if($value) {
            $this->selectedItems = Permission::pluck('id')->toArray();
        } else {
            $this->selectedItems = [];
        }

    }

    public function updatedSelectedPermissions($value)
    {
        if($this->selectAll) {
            $this->selectAll = false;
        }

    }

    public function deleteSelected()
    {
        if(!auth()->user()->can('admin_permissions_delete')) {
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
        if(!auth()->user()->can('admin_permissions_delete')) {
            return abort(403);
        }

        Permission::query()
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
        if(!auth()->user()->can('admin_permissions_index')) {
            return abort(403);
        }

        $permissions = Permission::where('name', 'LIKE', '%' . $this->search . '%')->orderBy($this->sortColumn, $this->sortDirection)->paginate($this->perPage);
        return view('jetadmin::livewire.admin.user.permission.index', compact('permissions'))->layout('layouts.admin');
    }
}
