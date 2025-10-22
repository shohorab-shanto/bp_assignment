<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return redirect()->route('categories.index');
});

// Resource routes for CRUD operations
Route::resource('categories', CategoryController::class);
Route::resource('subcategories', SubcategoryController::class);
Route::resource('products', ProductController::class);

// Slug-based product viewing route
Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('product.view');
