<?php

namespace App\Livewire\Tables\Admin;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class CategoriesTable extends DataTableComponent
{
    protected $model = Category::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function builder(): Builder
    {
        return Category::query()->with('parent');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->sortable(),
            Column::make('Название', 'name')->searchable()->sortable(),
            Column::make('Alias', 'alias')->searchable()->sortable(),
            Column::make('Родитель', 'parent.name')->sortable(),
            Column::make('Действия')
                ->label(fn ($row) => view('backend.categories.partials.actions', ['category' => $row]))
                ->html(),
        ];
    }
}
