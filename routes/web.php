<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('dashboard');
})->name('home');

/*
|--------------------------------------------------------------------------
| Authentication Routes (Manual)
|--------------------------------------------------------------------------
*/
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
// Nantinya Anda bisa menambahkan middleware ['auth', 'admin'] di sini
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Pengelolaan Produk
    Route::prefix('produk')->name('produk.')->group(function () {
        Route::get('/create', [AdminController::class, 'create'])->name('create');
        Route::post('/store', [AdminController::class, 'store'])->name('store');
        // Anda bisa menambah rute edit, update, delete di sini
    });

    // Pengelolaan Kategori & Promo (Sesuai ERD)
    // Route::resource('kategori', KategoriController::class);
    // Route::resource('promo', PromoController::class);
});