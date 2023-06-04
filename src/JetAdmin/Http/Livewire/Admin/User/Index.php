<?php

namespace AliQasemzadeh\JetAdmin\Http\Livewire\Admin\User;

use App\Exports\UsersExport;
use AliQasemzadeh\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $selectedUsers = [];
    public $selectAll = false;

    public $user;
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


    public function delete(User $user)
    {
        if(!auth()->user()->can('admin_user_delete')) {
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
        $this->user = $user;
    }

    public function confirmedDelete()
    {
        if(!auth()->user()->can('admin_user_delete')) {
            return abort(403);
        }
        $this->user->delete();
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
        $this->search = request()->query('search', $this->search);
    }

    public function updatedSelectAll($value)
    {
        if($value) {
            $this->selectedUsers = User::pluck('id')->toArray();
        } else {
            $this->selectedUsers = [];
        }

    }

    public function updatedSelectedUsers($value)
    {
        if($this->selectAll) {
            $this->selectAll = false;
        }
    }

    public function deleteSelected()
    {
        if(!auth()->user()->can('admin_user_delete')) {
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
        if(!auth()->user()->can('admin_user_delete')) {
            return abort(403);
        }
        User::query()
            ->whereIn('id', $this->selectedUsers)
            ->delete();
        $this->selectedUsers = [];
        $this->selectAll = false;

        $this->alert(
            'success',
            __('jetadmin::removed')
        );
    }

    public function exportSelectedQuery()
    {
        return Excel::download(new UsersExport($this->selectedUsers), 'users-'.date('Y-m-d').'.xlsx');
    }

    public function render()
    {
        if(!auth()->user()->can('admin_user_index')) {
            return abort(403);
        }
        $users = User::filter(['search' => $this->search])->orderBy($this->sortColumn, $this->sortDirection)->paginate($this->perPage);
        return view('jetadmin::livewire.admin.user.index', compact('users'))->layout('layouts.admin');
    }
}
