<?php

namespace AliQasemzadeh\JetAdmin\Livewire\Admin\User\Role;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $selectedRoles = [];
    public $selectAll = false;

    public $role;
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
    public function delete(Role $role)
    {
        if(!auth()->user()->can('admin_roles_delete')) {
            return abort(403);
        }

        $this->confirm(__('jetadmin::jetadmin.are_you_sure'), [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => __('jetadmin::jetadmin.cancel'),
            'onConfirmed' => 'confirmedDelete',
            'onCancelled' => 'cancelledDelete'
        ]);
        $this->role = $role;
    }

    public function confirmedDelete()
    {
        if(!auth()->user()->can('admin_roles_delete')) {
            return abort(403);
        }

        $this->role->delete();
        $this->dispatch('updateList');
        $this->alert(
            'success',
            __('jetadmin::jetadmin.removed')
        );
    }

    public function cancelledDelete()
    {
        $this->alert(
            'success',
            __('jetadmin::jetadmin.cancelled')
        );
    }

    public function mount()
    {
        if(!auth()->user()->can('admin_roles_index')) {
            return abort(403);
        }

        $this->search = request()->query('search', $this->search);
    }

    public function updatedSelectAll($value)
    {
        if($value) {
            $this->selectedRoles = Role::pluck('id')->toArray();
        } else {
            $this->selectedRoles = [];
        }

    }

    public function updatedSelectedRoles($value)
    {
        if($this->selectAll) {
            $this->selectAll = false;
        }

    }

    public function deleteSelected()
    {
        $this->confirm(__('jetadmin::jetadmin.are_you_sure'), [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => __('jetadmin::jetadmin.cancel'),
            'onConfirmed' => 'deleteSelectedQuery',
            'onCancelled' => 'cancelledDelete'
        ]);
    }

    public function deleteSelectedQuery()
    {
        if(!auth()->user()->can('admin_roles_delete')) {
            return abort(403);
        }

        Role::query()
            ->whereIn('id', $this->selectedRoles)
            ->delete();
        $this->selectedRoles = [];
        $this->selectAll = false;

        $this->alert(
            'success',
            __('jetadmin::jetadmin.removed')
        );
    }

    #[On('admin.user.role.index')]
    public function render()
    {
        if(!auth()->user()->can('admin_roles_index')) {
            return abort(403);
        }

        $roles = Role::where('name', 'LIKE', '%' . $this->search . '%')->orderBy($this->sortColumn, $this->sortDirection)->paginate($this->perPage);
        return view('jetadmin::livewire.admin.user.role.index', compact('roles'))->layout('layouts.admin');
    }
}
