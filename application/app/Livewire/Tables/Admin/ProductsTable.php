<?php

namespace App\Livewire\Tables\Admin;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ProductsTable extends DataTableComponent
{
    protected $model = Product::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function builder(): Builder
    {
        return Product::query()->with('category');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->sortable(),
            Column::make('Название', 'name')->searchable()->sortable(),
            Column::make('Категория', 'category.name')->sortable(),
            Column::make('Цена', 'price')->sortable(),
            Column::make('В наличии', 'in_stock')
                ->format(fn ($value) => $value ? 'Да' : 'Нет'),
            Column::make('Рейтинг', 'rating')->sortable(),
            Column::make('Действия')
                ->label(fn ($row) => view('backend.products.partials.actions', ['product' => $row]))
                ->html(),
        ];
    }
}
