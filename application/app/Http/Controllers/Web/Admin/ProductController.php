<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\Products\StoreRequest;
use App\Http\Requests\Web\Admin\Products\UpdateRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('backend.products.index');
    }

    public function create(): View
    {
        $categories = Category::query()->orderBy('name')->get();

        return view('backend.products.create', compact('categories'));
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        Product::query()->create($request->validated());

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Товар успешно создан.');
    }

    public function edit(Product $product): View
    {
        $categories = Category::query()->orderBy('name')->get();

        return view('backend.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->validated());

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Товар успешно обновлен.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Товар удален.');
    }
}
