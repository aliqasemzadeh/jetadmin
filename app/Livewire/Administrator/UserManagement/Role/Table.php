<?php

namespace App\Livewire\Administrator\UserManagement\Role;

use Spatie\Permission\Models\Role;
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

    public string $tableName = 'administrator.user-management.role.index';

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
                ->can(auth()->user()->can('administrator_user_role_create'))
                ->slot(__('jetadmin.create_role'))
                ->class('btn-indigo btn-default')
                ->dispatch('modal-show', ['name' => 'administrator.user-management.role.create.modal']),
        ];
    }

    public function datasource(): \Illuminate\Database\Eloquent\Builder
    {
        return Role::query();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('guard_name')
            ->add('created_at_formatted', fn ($model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::make(__('jetadmin.id'), 'id'),
            Column::make(__('jetadmin.name'), 'name')
                ->sortable()
                ->searchable(),

            Column::make(__('jetadmin.guard_name'), 'guard_name')
                ->sortable()
                ->searchable(),

            Column::make(__('jetadmin.created_at'), 'created_at_formatted', 'created_at')
                ->sortable(),
            Column::action(__('jetadmin.action'))

        ];
    }

    public function filters(): array
    {
        return [
            Filter::datetimepicker('created_at'),
        ];
    }

    #[\Livewire\Attributes\On('delete')]
    public function delete($id): void
    {
        Role::findById($id)->delete();
        $this->dispatch('pg:eventRefresh-administrator.user-management.role.index');
    }

    public function actions($row): array
    {
        return [
            Button::add('edit')
                ->slot(__('jetadmin.edit'))
                ->id()
                ->can(auth()->user()->can('administrator_user_role_edit'))
                ->class('btn-blue btn-xs')
                ->dispatch('modal-show', ['name' => 'administrator.user-management.role.edit.modal', 'arguments' => ['id' => $row->id]]),
            Button::add('users')
                ->slot(__('jetadmin.users'))
                ->id()
                ->can(auth()->user()->can('administrator_user_role_users'))
                ->class('btn-slate btn-xs')
                ->dispatch('modal-show', ['name' => 'administrator.user-management.role.users.modal', 'arguments' => ['id' => $row->id]]),
            Button::add('roles')
                ->slot(__('jetadmin.permissions'))
                ->id()
                ->can(auth()->user()->can('administrator_user_role_permissions'))
                ->class('btn-pink btn-xs')
                ->dispatch('modal-show', ['component' => 'administrator.user-management.role.permissions.modal', 'arguments' => ['id' => $row->id]]),
            Button::add('delete')
                ->slot(__('jetadmin.delete'))
                ->id()
                ->can(auth()->user()->can('administrator_user_role_delete'))
                ->class('btn-red btn-xs')
                ->confirm(__('jetadmin.are_you_sure'))
                ->dispatch('delete', ['id' => $row->id])

        ];
    }
}
