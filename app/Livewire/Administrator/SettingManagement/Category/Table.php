<?php

namespace App\Livewire\Administrator\SettingManagement\Category;

use App\Models\Setting\Category;
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

    public string $tableName = 'administrator.setting-management.category.index';

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
            Button::add('create-user')
                ->can(auth()->user()->can('administrator_setting_category_create'))
                ->slot(__('jetadmin.create_category'))
                ->class('btn-indigo btn-default')
                ->dispatch('modal-show', ['name' => 'administrator.setting-management.category.create.modal']),
        ];
    }

    public function datasource(): \Illuminate\Database\Eloquent\Builder
    {
        return Category::query();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('title')
            ->add('type')
            ->add('created_at_formatted', fn ($model) => Carbon::parse($model->created_at))
            ->add('updated_at_formatted', fn ($model) => Carbon::parse($model->updated_at))
            ->add('deleted_at_formatted', fn ($model) => Carbon::parse($model->deleted_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::make(__('jetadmin.id'), 'id'),
            Column::make(__('jetadmin.title'), 'title')
                ->sortable()
                ->searchable(),
            Column::make(__('jetadmin.type'), 'type')
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

    #[\Livewire\Attributes\On('delete')]
    public function delete($id): void
    {
        Category::findOrFail($id)->delete();
        $this->dispatch('pg:eventRefresh-administrator.setting-management.category.table');
    }

    public function actions($row): array
    {
        return [
            Button::add('edit')
                ->slot(__('jetadmin.edit'))
                ->id()
                ->can(auth()->user()->can('administrator_setting_category_edit'))
                ->class('btn-blue btn-xs')
                ->dispatch("administrator.setting-management.user.category.assign-data", [$row->id]),
            Button::add('delete')
                ->slot(__('jetadmin.delete'))
                ->id()
                ->can(auth()->user()->can('administrator_setting_category_delete'))
                ->class('btn-red btn-xs')
                ->confirm(__('jetadmin.are_you_sure'))
                ->dispatch('delete', ['id' => $row->id])
        ];
    }
}
