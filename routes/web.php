<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\Produk;

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
| Authentication Routes 
|--------------------------------------------------------------------------
*/
Route::controller(LoginController::class)->group(function () {
    // Keduanya mengarah ke view yang sama (slide form)
    Route::get('/login', 'showAuthForm')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    // Rute GET register juga diarahkan ke form yang sama
    Route::get('/register', fn() => redirect()->route('login'));
    Route::post('/register', 'register')->name('register');
});
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
// Nantinya Anda bisa menambahkan middleware ['auth', 'admin'] di sini
Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin -> /admin
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // Pengelolaan Produk -> /admin/produk/...
    Route::prefix('produk')->name('produk.')->group(function () {
        Route::get('/', [ProdukController::class, 'index'])->name('index'); // Menjadi /admin/produk
        Route::get('/create', [ProdukController::class, 'create'])->name('create'); // Menjadi /admin/produk/create
        Route::post('/', [ProdukController::class, 'store'])->name('store'); // Menjadi /admin/produk (POST)

        Route::get('/{id}/edit', [ProdukController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProdukController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProdukController::class, 'destroy'])->name('destroy');
    });

    // Pengelolaan Kategori -> /admin/kategori/...
    Route::prefix('kategori')->name('kategori.')->group(function () {
        Route::get('/', [KategoriController::class, 'index'])->name('index'); // Menjadi /admin/kategori
        Route::post('/', [KategoriController::class, 'store'])->name('store'); // Menjadi /admin/kategori (POST)
        Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('destroy'); // Menjadi /admin/kategori/{id}
    });
});
