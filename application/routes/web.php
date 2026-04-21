<?php

use App\Http\Controllers\Web\StorefrontController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Admin\CategoryController;
use App\Http\Controllers\Web\Admin\ProductController;

Route::get('/', [StorefrontController::class, 'home'])->name('frontend.home');
Route::get('/catalog', [StorefrontController::class, 'catalog'])->name('frontend.catalog');
Route::get('/products/{product}', [StorefrontController::class, 'show'])->name('frontend.products.show');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'admin.access',
])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('backend.dashboard');
    })->name('dashboard');

    Route::resource('products', ProductController::class)->except(['show']);
    Route::resource('categories', CategoryController::class)->except(['show']);
});

Route::redirect('/dashboard', '/admin')->name('dashboard');
