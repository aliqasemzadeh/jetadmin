<?php

namespace App\Livewire\Administrator\ContentManagement\Article;

use App\Models\Content\Article;
use App\Models\Content\FrequentlyAskedQuestion;
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

    public string $tableName = 'administrator.content-management.article.table';

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
            Button::add('create-article')
                ->can(auth()->user()->can('administrator_content_article_create'))
                ->slot(__('jetadmin.create_article'))
                ->class('btn-indigo btn-default')
                ->dispatch('modal-show', ['name' => 'administrator.content-management.article.create.modal']),
        ];
    }

    public function datasource(): \Illuminate\Database\Eloquent\Builder
    {
        return Article::query();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('title')
            ->add('pre_title')
            ->add('category_id')
            ->add('user_id')
            ->add('user_name', fn ($model) => $model->user->name ?? '')
            ->add('description')
            ->add('language')
            ->add('public')
            ->add('likes')
            ->add('views')
            ->add('publish_at_formatted', fn ($model) => Carbon::parse($model->publish_at)->format('d/m/Y H:i:s'))
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
            Column::make(__('jetadmin.pre_title'), 'pre_title')
                ->sortable()
                ->searchable(),
            Column::make(__('jetadmin.user'), 'user_name')
                ->sortable()
                ->searchable(),
            Column::make(__('jetadmin.language'), 'language')
                ->sortable()
                ->searchable(),
            Column::make(__('jetadmin.public'), 'public')
                ->sortable()
                ->searchable(),
            Column::make(__('jetadmin.publish_at'), 'publish_at_formatted', 'publish_at')
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
        Article::findOrFail($id)->delete();
        $this->dispatch('pg:eventRefresh-administrator.content-management.article.table');
    }

    public function actions($row): array
    {
        return [
            Button::add('edit')
                ->slot(__('jetadmin.edit'))
                ->id()
                ->can(auth()->user()->can('administrator_content_article_edit'))
                ->class('btn-blue btn-xs')
                ->dispatch("administrator.content-management.article.edit.assign-data", [$row->id]),
            Button::add('delete')
                ->slot(__('jetadmin.delete'))
                ->id()
                ->can(auth()->user()->can('administrator_content_article_delete'))
                ->class('btn-red btn-xs')
                ->confirm(__('jetadmin.are_you_sure'))
                ->dispatch('delete', ['id' => $row->id])
        ];
    }
}
