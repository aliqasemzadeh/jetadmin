<?php

namespace App\Livewire\Administrator\ContentManagement\Faq;

use App\Models\Content\FrequentlyAskedQuestion;
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

    public string $tableName = 'administrator.content-management.faq.table';

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
            Button::add('create-faq')
                ->can(auth()->user()->can('administrator_content_faq_create'))
                ->slot(__('jetadmin.create_faq'))
                ->class('btn-indigo btn-default')
                ->dispatch('modal-show', ['name' => 'administrator.content-management.faq.create.modal']),
        ];
    }

    public function datasource(): \Illuminate\Database\Eloquent\Builder
    {
        return FrequentlyAskedQuestion::query();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('question')
            ->add('answer')
            ->add('language')
            ->add('sort_order')
            ->add('created_at_formatted', fn ($model) => Carbon::parse($model->created_at))
            ->add('updated_at_formatted', fn ($model) => Carbon::parse($model->updated_at))
            ->add('deleted_at_formatted', fn ($model) => Carbon::parse($model->deleted_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::make(__('jetadmin.id'), 'id'),
            Column::make(__('jetadmin.question'), 'question')
                ->sortable()
                ->searchable(),
            Column::make(__('jetadmin.answer'), 'answer')
                ->sortable()
                ->searchable(),
            Column::make(__('jetadmin.language'), 'language')
                ->sortable()
                ->searchable(),
            Column::make(__('jetadmin.sort_order'), 'sort_order')
                ->sortable(),
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
        FrequentlyAskedQuestion::findOrFail($id)->delete();
        $this->dispatch('pg:eventRefresh-administrator.content-management.faq.table');
    }

    public function actions($row): array
    {
        return [
            Button::add('edit')
                ->slot(__('jetadmin.edit'))
                ->id()
                ->can(auth()->user()->can('administrator_content_faq_edit'))
                ->class('btn-blue btn-xs')
                ->dispatch("administrator.content-management.faq.edit.assign-data", [$row->id]),
            Button::add('delete')
                ->slot(__('jetadmin.delete'))
                ->id()
                ->can(auth()->user()->can('administrator_content_faq_delete'))
                ->class('btn-red btn-xs')
                ->confirm(__('jetadmin.are_you_sure'))
                ->dispatch('delete', ['id' => $row->id])
        ];
    }
}
