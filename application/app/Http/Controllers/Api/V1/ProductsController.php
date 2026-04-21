<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Products\IndexRequest;
use App\Http\Requests\Api\V1\Products\StoreRequest;
use App\Http\Requests\Api\V1\Products\UpdateRequest;
use App\Models\Product;
use App\Services\ProductsService;
use Illuminate\Http\JsonResponse;

class ProductsController extends Controller
{
    public function __construct(
        protected ProductsService $productsService
    ) {
    }

    public function index(IndexRequest $request): JsonResponse
    {
        return $this->productsService->index($request);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        return $this->productsService->store($request);
    }

    public function show(Product $product): JsonResponse
    {
        return $this->productsService->show($product);
    }

    public function update(UpdateRequest $request, Product $product): JsonResponse
    {
        return $this->productsService->update($request, $product);
    }

    public function destroy(Product $product): JsonResponse
    {
        return $this->productsService->destroy($product);
    }
}
