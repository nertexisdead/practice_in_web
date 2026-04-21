@php($tone = $product->id % 4)

<article class="store-product-card tone-{{ $tone }}">
    <div class="store-product-card__media">
        <span class="store-product-card__chip">{{ $product->category?->name ?? 'Каталог' }}</span>
        <span class="store-product-card__sku">{{ $product->getSku() }}</span>
        <div class="store-product-card__orb"></div>
    </div>

    <div class="store-product-card__body">
        <div class="store-product-card__meta">
            <span>{{ $product->category?->parent?->name ?? 'Автотовары' }}</span>
            <span>{{ $product->getStockLabel() }}</span>
        </div>

        <h3>{{ $product->name }}</h3>
        <p>{{ $product->getStorefrontDescription() }}</p>

        <div class="store-rating" style="--rating-width: {{ $product->getRatingPercentage() }}%;">
            <span class="store-rating__stars" aria-hidden="true">★★★★★</span>
            <span class="store-rating__value">{{ number_format($product->getRating(), 1, ',', ' ') }}</span>
        </div>

        <div class="store-product-card__footer">
            <div>
                <span class="store-product-card__price-label">Цена</span>
                <strong>{{ $product->getPriceFormatted() }}</strong>
            </div>

            <a href="{{ route('frontend.products.show', $product) }}" class="store-button store-button--dark">
                Смотреть
            </a>
        </div>
    </div>
</article>
