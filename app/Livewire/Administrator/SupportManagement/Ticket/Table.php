<?php

namespace App\Livewire\Administrator\SupportManagement\Ticket;

use App\Models\Content\Article;
use App\Models\Content\FrequentlyAskedQuestion;
use App\Models\Support\Ticket;
use App\Models\User;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class Table extends PowerGridComponent
{
    use WithExport;

    public string $tableName = 'administrator.support-management.ticket.table';

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::exportable(fileName: $this->tableName."-".date("Y-m-d-H-i-s"))
                ->striped()
                ->type(\PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function header(): array
    {
        return [
        ];
    }

    public function datasource(): \Illuminate\Database\Eloquent\Builder
    {
        return Ticket::query()->with(['user', 'category'])->whereIn('status', ['new', 'user']);
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('title')
            ->add('user_name', fn ($model) => $model->user->name ?? '')
            ->add('created_at_formatted', fn ($model) => Carbon::parse($model->created_at))
            ->add('updated_at_formatted', fn ($model) => Carbon::parse($model->updated_at));
    }

    public function columns(): array
    {
        return [
            Column::make(__('jetadmin.id'), 'id'),
            Column::make(__('jetadmin.title'), 'title')
                ->sortable()
                ->searchable(),
            Column::make(__('jetadmin.user'), 'user_name')
                ->sortable()
                ->searchable(),
            Column::make(__('jetadmin.created_at'), 'created_at_formatted', 'created_at')
                ->sortable(),
            Column::make(__('jetadmin.updated_at'), 'updated_at_formatted', 'updated_at')
                ->sortable(),
            Column::action(__('jetadmin.action'))
        ];
    }

    public function filters(): array
    {
        return [
            Filter::datetimepicker('created_at'),
            Filter::datetimepicker('updated_at'),
        ];
    }

    public function actions($row): array
    {
        return [
            Button::add('view')
                ->slot(__('jetadmin.view'))
                ->can('administrator_support_ticket_view')
                ->id()
                ->class('btn-green btn-xs')
                ->route("administrator.support-management.ticket.view", [$row->id])
        ];
    }
}
