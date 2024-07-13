<?php

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->middleware('verified')->name('dashboard');

    Route::prefix('profile')
        ->name('profile.')
        ->controller(ProfileController::class)
        ->group(function () {
        Route::get('', 'edit')->name('edit');
        Route::patch('', 'update')->name('update');
        Route::delete('', 'destroy')->name('destroy');
    });

    Route::prefix('products')
        ->name('products.')
        ->controller(ProductsController::class)
        ->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('', 'store')->name('store');
        Route::prefix('{product}')->group(function () {
            Route::get('', 'show')->name('show');
            Route::get('edit', 'edit')->name('edit');
            Route::put('', 'update')->name('update');
            Route::delete('', 'destroy')->name('destroy');
        });
    });
});

require __DIR__.'/auth.php';
