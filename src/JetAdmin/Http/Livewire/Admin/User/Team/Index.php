<?php

namespace AliQasemzadeh\JetAdmin\Http\Livewire\Admin\User\Team;

use AliQasemzadeh\Models\Article;
use AliQasemzadeh\Models\Team;
use AliQasemzadeh\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $selectedItems = [];
    public $selectAll = false;

    public $search;
    public $team;
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

    public function deleteSelected()
    {
        if(!auth()->user()->can('admin_team_delete')) {
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
        if(!auth()->user()->can('admin_team_delete')) {
            return abort(403);
        }

        Team::query()
            ->whereIn('id', $this->selectedItems)
            ->delete();
        $this->selectedItems = [];
        $this->selectAll = false;

        $this->alert(
            'success',
            __('jetadmin::removed')
        );
    }

    public function updatedSelectAll($value)
    {
        if($value) {
            $this->selectedItems = Team::pluck('id')->toArray();
        } else {
            $this->selectedItems = [];
        }
    }

    public function delete(Team $team)
    {
        if(!auth()->user()->can('admin_team_delete')) {
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

        $this->team = $team;
    }

    public function confirmedDelete()
    {
        if(!auth()->user()->can('admin_team_delete')) {
            return abort(403);
        }

        $this->team->delete();
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

    public function render()
    {
        if(!auth()->user()->can('admin_user_teams')) {
            return abort(403);
        }

        $teams = \AliQasemzadeh\JetAdmin\Models\Team::where('name', 'LIKE', '%' . $this->search . '%')->orderBy($this->sortColumn, $this->sortDirection)->paginate($this->perPage);

        return view('jetadmin::livewire.admin.user.team.index', compact('teams'))->layout('layouts.admin');
    }
}
