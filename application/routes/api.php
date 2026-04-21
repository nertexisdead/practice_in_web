<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ProductsController as ProductsV1Controller;
use App\Http\Controllers\Api\V1\CategoriesController as CategoriesV1Controller;

Route::group([
    'prefix' => 'v1/products',
    'as' => 'v1.products.',
], function () {
    Route::get('/', [ProductsV1Controller::class, 'index'])->name('index');
    Route::post('/', [ProductsV1Controller::class, 'store'])->name('store');
    Route::get('/{product}', [ProductsV1Controller::class, 'show'])->name('show');
    Route::put('/{product}', [ProductsV1Controller::class, 'update'])->name('update');
    Route::patch('/{product}', [ProductsV1Controller::class, 'update'])->name('patch');
    Route::delete('/{product}', [ProductsV1Controller::class, 'destroy'])->name('destroy');
});

Route::group([
    'prefix' => 'v1/categories',
    'as' => 'v1.categories.',
], function () {
    Route::get('/', [CategoriesV1Controller::class, 'index'])->name('index');
    Route::post('/', [CategoriesV1Controller::class, 'store'])->name('store');
    Route::get('/{category}', [CategoriesV1Controller::class, 'show'])->name('show');
    Route::put('/{category}', [CategoriesV1Controller::class, 'update'])->name('update');
    Route::patch('/{category}', [CategoriesV1Controller::class, 'update'])->name('patch');
    Route::delete('/{category}', [CategoriesV1Controller::class, 'destroy'])->name('destroy');
});
