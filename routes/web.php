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

Auth::routes();

Route::middleware(['auth'])->group(
    function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

        // Keranjang
        Route::get('cart', [App\Http\Controllers\Customer\CartController::class, 'cart'])->name('customer.cart');

        // user admin
        Route::prefix('/admin')->group(function () {

            // dashboard
            Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

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
