<?php

namespace App\Services;

use App\Http\Requests\Api\V1\Categories\IndexRequest;
use App\Http\Requests\Api\V1\Categories\StoreRequest;
use App\Http\Requests\Api\V1\Categories\UpdateRequest;
use App\Http\Resources\Api\V1\Categories\Collection;
use App\Http\Resources\Api\V1\Categories\Resource;
use App\Http\Resources\SuccessResponseResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class CategoriesService
{
    public function index(IndexRequest $request): JsonResponse
    {
        $filters = $request->get('filters', []);
        $orders = $request->get('orders', []);
        $perPage = min((int) $request->get('perPage', 20), 100);
        $page = max((int) $request->get('page', 1), 1);

        $result = $this->getIndexQuery($filters, $orders, $perPage, $page);

        return response()->json(
            new SuccessResponseResource(
                new Collection(
                    $result['categories'],
                    $filters,
                    $orders,
                    [
                        'page' => $page,
                        'itemsCount' => $result['total'],
                        'pages' => (int) ceil($result['total'] / $perPage),
                        'perPage' => $perPage,
                        'pageItemsCount' => count($result['categories']),
                        'next' => $page < ceil($result['total'] / $perPage) ? $page + 1 : null,
                        'prev' => $page > 1 ? $page - 1 : null,
                    ]
                )
            )
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $category = Category::query()->create($request->validated());

        return response()->json(
            new SuccessResponseResource(
                new Resource($category)
            ),
            201
        );
    }

    public function show(Category $category): JsonResponse
    {
        return response()->json(
            new SuccessResponseResource(
                new Resource($category)
            )
        );
    }

    public function update(UpdateRequest $request, Category $category): JsonResponse
    {
        $category->update($request->validated());

        return response()->json(
            new SuccessResponseResource(
                new Resource($category->fresh())
            )
        );
    }

    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return response()->json(
            new SuccessResponseResource()
        );
    }

    public function getIndexQuery(array $filters, array $orders, int $perPage, int $page): array
    {
        $query = Category::query();

        $filterMethods = [
            'q' => function ($value) use (&$query) {
                $query->where(function ($q) use ($value) {
                    $q->whereRaw('LOWER(name) LIKE ?', ['%' . Str::lower($value) . '%'])
                        ->orWhereRaw('LOWER(alias) LIKE ?', ['%' . Str::lower($value) . '%']);
                });
            },
            'parent_id' => function ($value) use ($query) {
                if ($value === null) {
                    return;
                }

                $query->where('parent_id', $value);
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
            'name' => function ($value) use ($query) {
                $query->orderBy('name', $value);
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

        $categories = $query->paginate($perPage, ['*'], 'page', $page);

        return [
            'categories' => $categories->items(),
            'total' => $categories->total(),
        ];
    }
}
