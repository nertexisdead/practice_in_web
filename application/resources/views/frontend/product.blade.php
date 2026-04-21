@extends('frontend.layouts.store', ['title' => $product->name . ' - Torque Lane'])

@section('content')
    <section class="store-page-intro store-page-intro--compact">
        <div class="store-shell">
            <nav class="store-breadcrumbs" aria-label="Хлебные крошки">
                <a href="{{ route('frontend.home') }}">Главная</a>
                <span>/</span>
                <a href="{{ route('frontend.catalog') }}">Каталог</a>
                @if ($product->category)
                    <span>/</span>
                    <a href="{{ route('frontend.catalog', ['category' => $product->category->id]) }}">{{ $product->category->name }}</a>
                @endif
            </nav>
        </div>
    </section>

    <section class="store-section store-section--product">
        <div class="store-shell">
            <div class="store-product-stage tone-{{ $product->id % 4 }}">
                <div class="store-product-stage__visual">
                    <span class="store-product-stage__chip">{{ $product->category?->name ?? 'Каталог' }}</span>
                    <strong>{{ $product->getSku() }}</strong>
                    <p>Выразительная карточка товара без лишней перегрузки, с акцентом на цену, рейтинг и быстрые сценарии выбора.</p>
                </div>

                <div class="store-product-stage__content">
                    <span class="store-kicker">Карточка товара</span>
                    <h1>{{ $product->name }}</h1>
                    <p class="store-product-stage__lead">{{ $product->getStorefrontDescription() }}</p>

                    <div class="store-rating store-rating--large" style="--rating-width: {{ $product->getRatingPercentage() }}%;">
                        <span class="store-rating__stars" aria-hidden="true">★★★★★</span>
                        <span class="store-rating__value">{{ number_format($product->getRating(), 1, ',', ' ') }} / 5</span>
                    </div>

                    <div class="store-product-stage__price-row">
                        <div>
                            <span class="store-product-stage__label">Цена</span>
                            <strong>{{ $product->getPriceFormatted() }}</strong>
                        </div>

                        <span class="store-badge {{ $product->getInStock() ? 'is-success' : 'is-muted' }}">
                            {{ $product->getStockLabel() }}
                        </span>
                    </div>

                    <div class="store-product-stage__actions">
                        <a href="{{ route('frontend.catalog') }}" class="store-button store-button--dark">Вернуться в каталог</a>
                        @auth
                            @if (auth()->user()->hasRole('admin', 'superadmin'))
                                <a href="{{ route('admin.products.edit', $product) }}" class="store-button store-button--ghost">Редактировать в админке</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>

            <div class="store-detail-grid">
                <div class="store-detail-card">
                    <span class="store-kicker">Позиция</span>
                    <h2>Ключевые параметры</h2>

                    <dl class="store-specs">
                        <div>
                            <dt>Артикул</dt>
                            <dd>{{ $product->getSku() }}</dd>
                        </div>
                        <div>
                            <dt>Категория</dt>
                            <dd>{{ $product->category?->name ?? 'Без категории' }}</dd>
                        </div>
                        <div>
                            <dt>Родительский раздел</dt>
                            <dd>{{ $product->category?->parent?->name ?? 'Основной каталог' }}</dd>
                        </div>
                        <div>
                            <dt>Обновлено</dt>
                            <dd>{{ $product->getUpdatedAtFormatted() ?? '—' }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="store-detail-card">
                    <span class="store-kicker">Контекст</span>
                    <h2>Как подана эта карточка</h2>
                    <p>Страница собрана как витринная карточка интернет-магазина: сильный визуальный блок, большая цена, заметный статус наличия и аккуратный блок характеристик без перегрузки лишними таблицами.</p>
                    <p>На текущих данных мы не добавляли отдельные фотографии и длинные описания, поэтому дизайн опирается на типографику, цвет и структуру контента.</p>
                </div>

                <div class="store-detail-card">
                    <span class="store-kicker">Раздел</span>
                    <h2>{{ $product->category?->name ?? 'Каталог' }}</h2>
                    <p>В этой категории сейчас <strong>{{ number_format($categoryProductCount, 0, ',', ' ') }}</strong> товаров. Это удобно для перехода в похожие позиции и быстрых подборок.</p>
                    @if ($product->category)
                        <a href="{{ route('frontend.catalog', ['category' => $product->category->id]) }}" class="store-text-link">Открыть категорию</a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @if ($relatedProducts->isNotEmpty())
        <section class="store-section">
            <div class="store-shell">
                <div class="store-section__heading">
                    <div>
                        <span class="store-kicker">Похожие товары</span>
                        <h2>Еще позиции из этого раздела</h2>
                    </div>
                    @if ($product->category)
                        <a href="{{ route('frontend.catalog', ['category' => $product->category->id]) }}" class="store-text-link">Смотреть категорию</a>
                    @endif
                </div>

                <div class="store-product-grid">
                    @foreach ($relatedProducts as $relatedProduct)
                        @include('frontend.partials.product-card', ['product' => $relatedProduct])
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
