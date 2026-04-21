@extends('frontend.layouts.store', ['title' => 'Каталог - Torque Lane'])

@section('content')
    <section class="store-page-intro">
        <div class="store-shell">
            <span class="store-kicker">Каталог</span>
            <h1>{{ $selectedCategory?->name ? 'Подборка: ' . $selectedCategory->name : 'Все товары магазина' }}</h1>
            <p>Фильтруйте ассортимент по категории, цене, наличию и сортировке. Витрина строится на существующих данных товаров и категорий.</p>
        </div>
    </section>

    <section class="store-section store-section--catalog">
        <div class="store-shell store-catalog-layout">
            <aside class="store-filter-panel">
                <form action="{{ route('frontend.catalog') }}" method="GET" class="store-filter-form">
                    <div class="store-filter-panel__header">
                        <h2>Фильтры</h2>
                        <a href="{{ route('frontend.catalog') }}" class="store-text-link">Сбросить</a>
                    </div>

                    <div class="store-field">
                        <label for="catalog-search">Поиск</label>
                        <input
                            id="catalog-search"
                            type="text"
                            name="q"
                            value="{{ $filters['q'] }}"
                            placeholder="Название товара"
                        >
                    </div>

                    <div class="store-field">
                        <label for="catalog-category">Категория</label>
                        <select id="catalog-category" name="category">
                            <option value="">Все категории</option>
                            @foreach ($categoryTree as $rootCategory)
                                <optgroup label="{{ $rootCategory->name }}">
                                    <option value="{{ $rootCategory->id }}" @selected((int) $filters['category'] === $rootCategory->id)>
                                        {{ $rootCategory->name }} · {{ $rootCategory->products_count }}
                                    </option>

                                    @foreach ($rootCategory->children as $childCategory)
                                        <option value="{{ $childCategory->id }}" @selected((int) $filters['category'] === $childCategory->id)>
                                            — {{ $childCategory->name }} · {{ $childCategory->products_count }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <div class="store-field-group">
                        <div class="store-field">
                            <label for="catalog-price-from">Цена от</label>
                            <input
                                id="catalog-price-from"
                                type="number"
                                name="price_from"
                                min="0"
                                step="1"
                                value="{{ $filters['price_from'] }}"
                                placeholder="{{ number_format((float) ($priceSnapshot->min_price ?? 0), 0, ',', ' ') }}"
                            >
                        </div>

                        <div class="store-field">
                            <label for="catalog-price-to">Цена до</label>
                            <input
                                id="catalog-price-to"
                                type="number"
                                name="price_to"
                                min="0"
                                step="1"
                                value="{{ $filters['price_to'] }}"
                                placeholder="{{ number_format((float) ($priceSnapshot->max_price ?? 0), 0, ',', ' ') }}"
                            >
                        </div>
                    </div>

                    <div class="store-field">
                        <label for="catalog-sort">Сортировка</label>
                        <select id="catalog-sort" name="sort">
                            @foreach ($sortOptions as $value => $label)
                                <option value="{{ $value }}" @selected($filters['sort'] === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <label class="store-checkbox">
                        <input type="checkbox" name="in_stock" value="1" @checked($filters['in_stock'])>
                        <span>Только в наличии</span>
                    </label>

                    <button type="submit" class="store-button store-button--accent store-button--full">Применить фильтры</button>
                </form>
            </aside>

            <div class="store-catalog-content">
                <div class="store-results-bar">
                    <div>
                        <strong>{{ number_format($products->total(), 0, ',', ' ') }}</strong>
                        <span>товаров найдено</span>
                    </div>

                    @if ($activeFilters->isNotEmpty())
                        <div class="store-active-filters">
                            @foreach ($activeFilters as $filter)
                                <span class="store-chip">{{ $filter }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>

                @if ($products->count())
                    <div class="store-product-grid store-product-grid--catalog">
                        @foreach ($products as $product)
                            @include('frontend.partials.product-card', ['product' => $product])
                        @endforeach
                    </div>

                    @if ($products->hasPages())
                        @php($startPage = max(1, $products->currentPage() - 2))
                        @php($endPage = min($products->lastPage(), $products->currentPage() + 2))

                        <nav class="store-pagination" aria-label="Навигация по страницам каталога">
                            @if ($products->onFirstPage())
                                <span class="is-disabled">Назад</span>
                            @else
                                <a href="{{ $products->previousPageUrl() }}">Назад</a>
                            @endif

                            @for ($page = $startPage; $page <= $endPage; $page++)
                                @if ($page === $products->currentPage())
                                    <span class="is-current">{{ $page }}</span>
                                @else
                                    <a href="{{ $products->url($page) }}">{{ $page }}</a>
                                @endif
                            @endfor

                            @if ($products->hasMorePages())
                                <a href="{{ $products->nextPageUrl() }}">Вперед</a>
                            @else
                                <span class="is-disabled">Вперед</span>
                            @endif
                        </nav>
                    @endif
                @else
                    <div class="store-empty-state">
                        <span class="store-kicker">Ничего не найдено</span>
                        <h2>Попробуйте ослабить фильтры или начать заново.</h2>
                        <p>Каталог пуст только для текущей комбинации параметров. Общий ассортимент остается доступным через сброс фильтрации.</p>
                        <a href="{{ route('frontend.catalog') }}" class="store-button store-button--dark">Показать все товары</a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
