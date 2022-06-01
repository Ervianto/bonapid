<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [App\Http\Controllers\Customer\DashboardController::class, 'index'])->name('customer.dashboard');
Route::get('/signin', [App\Http\Controllers\Customer\AccountController::class, 'signin'])->name('customer.signin');
Route::post('/signup', [App\Http\Controllers\Customer\AccountController::class, 'signup'])->name('customer.signup');
Route::post('/account', [App\Http\Controllers\Customer\AccountController::class, 'index'])->name('customer.account');
Route::get('/produk/{id}', [App\Http\Controllers\Customer\DashboardController::class, 'detailProduk']);
Route::get('/get_kota', [App\Http\Controllers\Customer\AccountController::class, 'getCities']);
Auth::routes();

Route::middleware(['auth'])->group(
    function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

        Route::resource('customer-cart', App\Http\Controllers\Customer\CartController::class);
        Route::get('/checkout', [App\Http\Controllers\Customer\CheckoutController::class, 'index']);
        Route::post('/check_ongkir', [App\Http\Controllers\Customer\CheckoutController::class, 'check_ongkir']);
        Route::post('/payment', [App\Http\Controllers\Customer\CheckoutController::class, 'bayarSekarang']);
        Route::get('/customer-transaksi', [App\Http\Controllers\Customer\TransaksiController::class, 'index']);
        Route::get('/customer-transaksi/{id}', [App\Http\Controllers\Customer\TransaksiController::class, 'show']);
        Route::post('/payment_midtrains', [App\Http\Controllers\Customer\CheckoutController::class, 'paymentProsess']);
        Route::post('/store_review', [App\Http\Controllers\Customer\DashboardController::class, 'storeReview']);
        Route::get('/konfirmasi-barang-sampai/{id}', [App\Http\Controllers\Customer\TransaksiController::class, 'konfirmasi']);
        Route::post('/store_brg_sampai/{id}', [App\Http\Controllers\Customer\TransaksiController::class, 'konfirmasiBarangSampai']);
        Route::post('/delete-review/{id}', [App\Http\Controllers\Customer\DashboardController::class, 'deleteReview']);
        
        // user admin
        Route::prefix('/admin')->group(function () {

            // dashboard
            Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

            // stok
            Route::get('/stok', [App\Http\Controllers\Admin\BarangController::class, 'index'])->name('admin.stok');

            // kategori
            Route::get('/kategori', [App\Http\Controllers\Admin\KategoriController::class, 'index'])->name('admin.kategori');
            Route::post('/kategori/tambah', [App\Http\Controllers\Admin\KategoriController::class, 'store'])->name('admin.kategori-tambah');
            Route::get('/kategori/{id}/edit', [App\Http\Controllers\Admin\KategoriController::class, 'edit']);
            Route::post('/kategori/hapus', [App\Http\Controllers\Admin\KategoriController::class, 'destroy'])->name('admin.kategori-hapus');

            // barang
            Route::get('/barang', [App\Http\Controllers\Admin\BarangController::class, 'index'])->name('admin.barang');
            Route::post('/barang/tambah', [App\Http\Controllers\Admin\BarangController::class, 'store'])->name('admin.barang-tambah');
            Route::get('/barang/{id}/edit', [App\Http\Controllers\Admin\BarangController::class, 'edit']);
            Route::post('/barang/hapus', [App\Http\Controllers\Admin\BarangController::class, 'destroy'])->name('admin.barang-hapus');
            Route::post('/barang/tampilkan', [App\Http\Controllers\Admin\BarangController::class, 'tampilkan'])->name('admin.barang-tampilkan');

            // user
            Route::get('/user', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.user');
            Route::post('/user/tambah', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.user-tambah');
            Route::get('/user/{id}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit']);
            Route::post('/user/hapus', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.user-hapus');

            // about
            Route::get('/about', function () {
                return view('admin.about');
            })->name('admin.about');
        });
    }
);
