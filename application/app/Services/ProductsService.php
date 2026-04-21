<?php

namespace App\Services;

use App\Http\Resources\SuccessResponseResource;
use App\Http\Requests\Api\V1\Products\IndexRequest;
use App\Http\Requests\Api\V1\Products\StoreRequest;
use App\Http\Requests\Api\V1\Products\UpdateRequest;
use App\Http\Resources\Api\V1\Products\Collection;
use App\Http\Resources\Api\V1\Products\Resource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class ProductsService
{
    public function index(IndexRequest $request): JsonResponse
    {
        $filters = $request->get('filters', []);
        $orders = $request->get('orders', []);
        $perPage = min((int)$request->get('perPage', 20), 100);
        $page = max((int) $request->get('page', 1), 1);

        $result = $this->getIndexQuery($filters, $orders, $perPage, $page);

        return response()->json(
            new SuccessResponseResource(
                new Collection(
                    $result['products'],
                    $filters,
                    $orders,
                    [
                        'page' => $page,
                        'itemsCount' => $result['total'],
                        'pages' => ceil($result['total'] / $perPage),
                        'perPage' => $perPage,
                        'pageItemsCount' => count($result['products']),
                        'next' => $page < ceil($result['total'] / $perPage) ? $page + 1 : null,
                        'prev' => $page > 1 ? $page - 1 : null,
                    ]
                )
            )
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $product = Product::query()->create($request->validated());
        $product->load('category');

        return response()->json(
            new SuccessResponseResource(
                new Resource($product)
            ),
            201
        );
    }

    public function show(Product $product): JsonResponse
    {
        $product->load('category');

        return response()->json(
            new SuccessResponseResource(
                new Resource($product)
            )
        );
    }

    public function update(UpdateRequest $request, Product $product): JsonResponse
    {
        $product->update($request->validated());
        $product->load('category');

        return response()->json(
            new SuccessResponseResource(
                new Resource($product)
            )
        );
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json(
            new SuccessResponseResource()
        );
    }

    public function getIndexQuery(array $filters, array $orders, int $perPage, int $page): array
    {
        $query = Product::query()->with('category');

        $filterMethods = [
            'q' => function ($value) use (&$query) {
                $query->where(function ($q) use ($value) {
                    $q->whereRaw('LOWER(name) LIKE ?', ['%' . Str::lower($value) . '%']);
                });
            },
            'category_id' => function ($value) use (&$query) {
                $query->where('category_id', $value);
            },
            'price_from' => function ($value) use ($query) {
                if ($value === null) return;
                $query->where('price', '>=', (float) $value);
            },
            'price_to' => function ($value) use ($query) {
                if ($value === null) return;
                $query->where('price', '<=', (float) $value);
            },
            'in_stock' => function ($value) use ($query) {
                if ($value === null) return;
                $query->where('in_stock', filter_var($value, FILTER_VALIDATE_BOOLEAN));
            },
            'rating_from' => function ($value) use ($query) {
                if ($value === null) return;
                $query->where('rating', '>=', (float) $value);
            },
        ];

        $normalizedFilters = [];
        foreach ($filters as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $subKey => $subValue) {
                    $normalizedFilters["{$key}.{$subKey}"] = $subValue;
                }
            } else {
                $normalizedFilters[$key] = $value;
            }
        }

        foreach ($normalizedFilters as $key => $value) {
            if (isset($filterMethods[$key])) {
                $filterMethods[$key]($value);
            }
        }

        $orderMethods = [
            'price' => function ($value) use ($query) {
                $query->orderBy('price', $value);
            },
            'rating' => function ($value) use ($query) {
                $query->orderBy('rating', $value);
            },
            'created_at' => function ($value) use ($query) {
                $query->orderBy('created_at', $value);
            },
        ];

        foreach ($orders as $key => $value) {
            if (isset($orderMethods[$key])) {
                $orderMethods[$key]($value);
            }
        }

        if (!$orders) {
            $query->orderBy('id', 'desc');
        }

        $products = $query->paginate($perPage, ['*'], 'page', $page);

        return [
            'products' => $products->items(),
            'total' => $products->total(),
        ];
    }
}
