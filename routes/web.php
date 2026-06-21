<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Models\Produk;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('dashboard');

Route::get('/produk-detail/{id}', [HomeController::class, 'detail'])->name('produk.detail');

Route::get('/checkout-ebook/{id_produk}', [HomeController::class, 'checkoutEbook'])->name('checkout.ebook');

// Hapus atau ganti rute yang lama dengan ini:
Route::get('/kategori/{nama}', [HomeController::class, 'kategoriAll'])->name('kategori.all');

// Route untuk memproses form order dari halaman detail produk
Route::post('/transaksi/checkout', [TransaksiController::class, 'checkout'])->name('transaksi.checkout');

// Route untuk menampilkan halaman invoice beserta pop-up Midtrans
Route::get('/transaksi/pembayaran/{id_transaksi}', [TransaksiController::class, 'pembayaran'])->name('transaksi.pembayaran');

// Route untuk menampilkan halaman sukses pembayaran
Route::middleware(['auth'])->group(function () {
    // Halaman Riwayat Pembelian
    Route::get('/user/riwayat', [UserController::class, 'riwayat'])->name('user.riwayat');

    // Menampilkan Form Ulasan
    Route::get('/transaksi/{id_transaksi}/review', [UserController::class, 'createReview'])->name('user.review.create');

    // Menyimpan Data Ulasan ke Database
    Route::post('/transaksi/{id_transaksi}/review', [UserController::class, 'storeReview'])->name('user.review.store');
});

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


Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

// Proses pengiriman link reset password ke email
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
// Nantinya Anda bisa menambahkan middleware ['auth', 'admin'] di sini
Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin -> /admin
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/riwayat', [AdminController::class, 'riwayat'])->name('riwayat');
    });

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

    // Pengelolaan User -> /admin/users/...
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::patch('/{id}/role', [AdminUserController::class, 'updateRole'])->name('updateRole');
        Route::delete('/{id}', [AdminUserController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/edit', [AdminUserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminUserController::class, 'update'])->name('update');
    });


    // Pengelolaan Promo -> /admin/promo/...
    Route::prefix('promo')->name('promo.')->group(function () {
        Route::get('/', [PromoController::class, 'index'])->name('index'); // Menjadi admin.promo.index
        Route::get('/create', [PromoController::class, 'create'])->name('create'); // Menjadi admin.promo.create
        Route::post('/', [PromoController::class, 'store'])->name('store'); // Menjadi admin.promo.store
        Route::get('/{id}/edit', [PromoController::class, 'edit'])->name('edit'); // Menjadi admin.promo.edit
        Route::put('/{id}', [PromoController::class, 'update'])->name('update'); // Menjadi admin.promo.update
        Route::delete('/{id}', [PromoController::class, 'destroy'])->name('destroy'); // Menjadi admin.promo.destroy
    });

    // Pengelolaan Brand -> /admin/brand/...
    Route::prefix('brand')->name('brand.')->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('index');
        Route::get('/create', [BrandController::class, 'create'])->name('create');
        Route::post('/', [BrandController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [BrandController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BrandController::class, 'update'])->name('update');
        Route::delete('/{id}', [BrandController::class, 'destroy'])->name('destroy');
    });
});
