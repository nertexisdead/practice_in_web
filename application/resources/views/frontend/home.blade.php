@extends('frontend.layouts.store', ['title' => 'Torque Lane - интернет-магазин автодеталей'])

@section('content')
    <section class="store-hero">
        <div class="store-shell store-hero__inner">
            <div class="store-hero__content">
                <span class="store-kicker">Каталог с акцентом на скорость и визуальную подачу</span>
                <h1>Интернет-магазин автозапчастей с чистой витриной и понятным каталогом.</h1>
                <p>Подберите товары по категории, цене и наличию, а затем быстро перейдите в карточку позиции. Основа уже собрана на реальных данных вашего проекта.</p>

                <div class="store-hero__actions">
                    <a href="{{ route('frontend.catalog') }}" class="store-button store-button--accent">Открыть каталог</a>
                    <a href="#featured-products" class="store-button store-button--ghost">Посмотреть подборку</a>
                </div>

                <form action="{{ route('frontend.catalog') }}" method="GET" class="store-search-panel">
                    <label for="hero-search" class="visually-hidden">Поиск по каталогу</label>
                    <input id="hero-search" type="text" name="q" placeholder="Например, тормозные колодки или фильтр">
                    <button type="submit" class="store-button store-button--dark">Найти детали</button>
                </form>

                <div class="store-hero__chips">
                    @foreach ($featuredCategories->take(4) as $category)
                        <a href="{{ route('frontend.catalog', ['category' => $category->id]) }}" class="store-chip">
                            {{ $category->name }}
                            <span>{{ $category->products_count }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="store-hero__panel">
                <div class="store-hero-card store-hero-card--primary">
                    <p>Готово к продаже</p>
                    <strong>{{ number_format($stats['products'], 0, ',', ' ') }}</strong>
                    <span>товаров уже в каталоге</span>
                </div>

                <div class="store-hero-card-grid">
                    <div class="store-hero-card">
                        <p>Категории</p>
                        <strong>{{ number_format($stats['categories'], 0, ',', ' ') }}</strong>
                        <span>структурируют каталог</span>
                    </div>

                    <div class="store-hero-card">
                        <p>В наличии</p>
                        <strong>{{ $stats['availableShare'] }}%</strong>
                        <span>позиций доступны сразу</span>
                    </div>

                    <div class="store-hero-card store-hero-card--accent">
                        <p>Средний рейтинг</p>
                        <strong>{{ $stats['averageRating'] }}</strong>
                        <span>по текущему ассортименту</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="store-section">
        <div class="store-shell">
            <div class="store-section__heading">
                <div>
                    <span class="store-kicker">Категории</span>
                    <h2>Быстрый вход в разделы магазина</h2>
                </div>
                <a href="{{ route('frontend.catalog') }}" class="store-text-link">Открыть весь каталог</a>
            </div>

            <div class="store-category-grid">
                @foreach ($featuredCategories as $category)
                    <a href="{{ route('frontend.catalog', ['category' => $category->id]) }}" class="store-category-tile">
                        <span class="store-category-tile__count">{{ $category->products_count }} поз.</span>
                        <strong>{{ $category->name }}</strong>
                        <p>Перейти к подборке по категории и посмотреть доступные товары, цены и рейтинг.</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="store-section" id="featured-products">
        <div class="store-shell">
            <div class="store-section__heading">
                <div>
                    <span class="store-kicker">Новые поступления</span>
                    <h2>Свежие позиции для главной витрины</h2>
                </div>
                <a href="{{ route('frontend.catalog', ['sort' => 'newest']) }}" class="store-text-link">Сначала новое</a>
            </div>

            <div class="store-product-grid">
                @foreach ($freshProducts as $product)
                    @include('frontend.partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>

    <section class="store-section store-section--feature">
        <div class="store-shell store-feature-panel">
            <div class="store-feature-panel__copy">
                <span class="store-kicker">Почему такой storefront работает</span>
                <h2>Главная страница ведет пользователя от впечатления к выбору без лишнего шума.</h2>
                <p>Сначала мы показываем сильный hero-блок, затем понятные входы в категории и только после этого выводим карточки ассортимента. Такой порядок хорошо подходит для интернет-магазина и не требует отдельного SPA.</p>
            </div>

            <div class="store-feature-panel__products">
                @foreach ($featuredProducts as $product)
                    <a href="{{ route('frontend.products.show', $product) }}" class="store-feature-mini">
                        <strong>{{ $product->name }}</strong>
                        <span>{{ $product->category?->name ?? 'Каталог' }}</span>
                        <em>{{ $product->getPriceFormatted() }}</em>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endsection
