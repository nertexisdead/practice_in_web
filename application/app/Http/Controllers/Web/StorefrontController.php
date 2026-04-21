<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StorefrontController extends Controller
{
    public function home(): View
    {
        $featuredCategories = Category::query()
            ->withCount('products')
            ->has('products')
            ->orderByDesc('products_count')
            ->orderBy('name')
            ->limit(6)
            ->get();

        $freshProducts = Product::query()
            ->with('category.parent')
            ->latest('id')
            ->limit(8)
            ->get();

        $featuredProducts = Product::query()
            ->with('category.parent')
            ->where('in_stock', true)
            ->orderByDesc('rating')
            ->orderByDesc('id')
            ->limit(4)
            ->get();

        $totalProducts = Product::query()->count();
        $totalCategories = Category::query()->count();
        $availableProducts = Product::query()
            ->where('in_stock', true)
            ->count();

        $stats = [
            'products' => $totalProducts,
            'categories' => $totalCategories,
            'availableShare' => ($totalProducts > 0)
                ? (int) round($availableProducts / $totalProducts * 100)
                : 0,
            'averageRating' => number_format(
                (float) Product::query()->avg('rating'),
                1,
                ',',
                ' '
            ),
        ];

        return view('frontend.home', compact(
            'featuredCategories',
            'freshProducts',
            'featuredProducts',
            'stats',
        ));
    }

    public function catalog(Request $request): View
    {
        $filters = $this->getCatalogFilters($request);

        $productsQuery = Product::query()->with('category.parent');

        $this->applyCatalogFilters($productsQuery, $filters);
        $this->applyCatalogSort($productsQuery, $filters['sort']);

        $products = $productsQuery
            ->paginate(12)
            ->withQueryString();

        $categoryTree = Category::query()
            ->whereNull('parent_id')
            ->withCount('products')
            ->with([
                'children' => function ($query): void {
                    $query
                        ->withCount('products')
                        ->orderBy('name');
                },
            ])
            ->orderBy('name')
            ->get();

        $selectedCategory = $filters['category']
            ? Category::query()->find($filters['category'])
            : null;

        $priceSnapshot = Product::query()
            ->selectRaw('MIN(price) as min_price, MAX(price) as max_price')
            ->first();

        $activeFilters = collect([
            $filters['q'] !== '' ? "Поиск: {$filters['q']}" : null,
            $selectedCategory?->name,
            $filters['price_from'] !== null ? 'Цена от ' . number_format($filters['price_from'], 0, ',', ' ') . ' ₽' : null,
            $filters['price_to'] !== null ? 'Цена до ' . number_format($filters['price_to'], 0, ',', ' ') . ' ₽' : null,
            $filters['in_stock'] ? 'Только в наличии' : null,
        ])->filter()->values();

        $sortOptions = [
            'newest' => 'Сначала новое',
            'price_asc' => 'Цена по возрастанию',
            'price_desc' => 'Цена по убыванию',
            'rating_desc' => 'С высоким рейтингом',
            'name_asc' => 'По названию',
        ];

        return view('frontend.catalog', compact(
            'products',
            'filters',
            'categoryTree',
            'selectedCategory',
            'priceSnapshot',
            'activeFilters',
            'sortOptions',
        ));
    }

    public function show(Product $product): View
    {
        $product->load('category.parent');

        $relatedProducts = Product::query()
            ->with('category.parent')
            ->where('category_id', $product->category_id)
            ->whereKeyNot($product->id)
            ->orderByDesc('rating')
            ->orderByDesc('id')
            ->limit(4)
            ->get();

        $categoryProductCount = Product::query()
            ->where('category_id', $product->category_id)
            ->count();

        return view('frontend.product', compact(
            'product',
            'relatedProducts',
            'categoryProductCount',
        ));
    }

    private function getCatalogFilters(Request $request): array
    {
        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'category' => $this->toNullableInt($request->query('category')),
            'price_from' => $this->toNullableFloat($request->query('price_from')),
            'price_to' => $this->toNullableFloat($request->query('price_to')),
            'in_stock' => $request->boolean('in_stock'),
            'sort' => (string) $request->query('sort', 'newest'),
        ];

        if (
            $filters['price_from'] !== null
            && $filters['price_to'] !== null
            && $filters['price_from'] > $filters['price_to']
        ) {
            [$filters['price_from'], $filters['price_to']] = [
                $filters['price_to'],
                $filters['price_from'],
            ];
        }

        if (!array_key_exists($filters['sort'], $this->getSortMap())) {
            $filters['sort'] = 'newest';
        }

        return $filters;
    }

    private function applyCatalogFilters(Builder $query, array $filters): void
    {
        if ($filters['q'] !== '') {
            $query->where(function (Builder $searchQuery) use ($filters): void {
                $searchQuery->whereRaw(
                    'LOWER(name) LIKE ?',
                    ['%' . Str::lower($filters['q']) . '%']
                );
            });
        }

        if ($filters['category']) {
            $query->where('category_id', $filters['category']);
        }

        if ($filters['price_from'] !== null) {
            $query->where('price', '>=', $filters['price_from']);
        }

        if ($filters['price_to'] !== null) {
            $query->where('price', '<=', $filters['price_to']);
        }

        if ($filters['in_stock']) {
            $query->where('in_stock', true);
        }
    }

    private function applyCatalogSort(Builder $query, string $sort): void
    {
        foreach ($this->getSortMap()[$sort] as [$column, $direction]) {
            $query->orderBy($column, $direction);
        }
    }

    private function getSortMap(): array
    {
        return [
            'newest' => [
                ['id', 'desc'],
            ],
            'price_asc' => [
                ['price', 'asc'],
                ['id', 'desc'],
            ],
            'price_desc' => [
                ['price', 'desc'],
                ['id', 'desc'],
            ],
            'rating_desc' => [
                ['rating', 'desc'],
                ['id', 'desc'],
            ],
            'name_asc' => [
                ['name', 'asc'],
                ['id', 'desc'],
            ],
        ];
    }

    private function toNullableInt(mixed $value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        return max((int) $value, 0) ?: null;
    }

    private function toNullableFloat(mixed $value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        return max((float) $value, 0);
    }
}
