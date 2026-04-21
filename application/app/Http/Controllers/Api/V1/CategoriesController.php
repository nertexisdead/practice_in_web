<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Categories\IndexRequest;
use App\Http\Requests\Api\V1\Categories\StoreRequest;
use App\Http\Requests\Api\V1\Categories\UpdateRequest;
use App\Models\Category;
use App\Services\CategoriesService;
use Illuminate\Http\JsonResponse;

class CategoriesController extends Controller
{
    public function __construct(
        protected CategoriesService $categoriesService
    ) {
    }

    public function index(IndexRequest $request): JsonResponse
    {
        return $this->categoriesService->index($request);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        return $this->categoriesService->store($request);
    }

    public function show(Category $category): JsonResponse
    {
        return $this->categoriesService->show($category);
    }

    public function update(UpdateRequest $request, Category $category): JsonResponse
    {
        return $this->categoriesService->update($request, $category);
    }

    public function destroy(Category $category): JsonResponse
    {
        return $this->categoriesService->destroy($category);
    }
}
