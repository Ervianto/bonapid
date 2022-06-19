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
Route::get('/home', [App\Http\Controllers\Customer\DashboardController::class, 'index'])->name('home');
Route::get('/signin', [App\Http\Controllers\Customer\AccountController::class, 'signin'])->name('customer.signin');
Route::post('/signup', [App\Http\Controllers\Customer\AccountController::class, 'signup'])->name('customer.signup');
Route::get('/produk/{id}', [App\Http\Controllers\Customer\DashboardController::class, 'detailProduk']);
Auth::routes();

Route::middleware(['auth'])->group(
    function () {

        Route::resource('customer-cart', App\Http\Controllers\Customer\CartController::class);
        Route::get('/checkout', [App\Http\Controllers\Customer\CheckoutController::class, 'index']);
        Route::post('/check_ongkir', [App\Http\Controllers\Customer\CheckoutController::class, 'check_ongkir']);
        Route::post('/payment', [App\Http\Controllers\Customer\CheckoutController::class, 'bayarSekarang']);
        Route::get('/customer-transaksi', [App\Http\Controllers\Customer\TransaksiController::class, 'index']);
        Route::get('/customer-transaksi/{id}', [App\Http\Controllers\Customer\TransaksiController::class, 'show']);
        Route::post('/payment_midtrains', [App\Http\Controllers\Customer\CheckoutController::class, 'paymentProsess']);

        // user admin
        Route::prefix('/admin')->group(function () {

            // dashboard
            Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
            Route::post('/dashboard/statistik', [App\Http\Controllers\Admin\DashboardController::class, 'statistik'])->name('admin.dashboard-statistik');
            Route::post('/dashboard/chart1', [App\Http\Controllers\Admin\DashboardController::class, 'chart1'])->name('admin.dashboard-chart1');
            Route::post('/dashboard/chart2', [App\Http\Controllers\Admin\DashboardController::class, 'chart2'])->name('admin.dashboard-chart2');

            // menu laporan
            // laporan transaksi
            Route::get('/laporan-trx', [App\Http\Controllers\Admin\LaporanController::class, 'indexTrx'])->name('admin.laporan-transaksi');
            Route::get('/laporan-stk', [App\Http\Controllers\Admin\LaporanController::class, 'indexStok'])->name('admin.laporan-stok');

            // menu transaksi
            // transaksi
            Route::get('/transaksi', [App\Http\Controllers\Admin\TransaksiController::class, 'index'])->name('admin.transaksi');
            Route::post('/transaksi/detail', [App\Http\Controllers\Admin\TransaksiController::class, 'detail']);
            Route::get('/transaksi/{id}/edit', [App\Http\Controllers\Admin\TransaksiController::class, 'edit']);
            Route::post('/transaksi/hapus', [App\Http\Controllers\Admin\TransaksiController::class, 'destroy'])->name('admin.transaksi-hapus');

            // preorder
            Route::get('/preorder', [App\Http\Controllers\Admin\PreOrderController::class, 'index'])->name('admin.preorder');
            Route::post('/preorder/detail', [App\Http\Controllers\Admin\PreOrderController::class, 'detail']);
            Route::get('/preorder/{id}/edit', [App\Http\Controllers\Admin\PreOrderController::class, 'edit']);
            Route::post('/preorder/kirim', [App\Http\Controllers\Admin\PreOrderController::class, 'update'])->name('admin.preorder-update');
            Route::post('/preorder/hapus', [App\Http\Controllers\Admin\PreOrderController::class, 'destroy'])->name('admin.preorder-hapus');

            // pengiriman
            Route::get('/pengiriman', [App\Http\Controllers\Admin\PengirimanController::class, 'index'])->name('admin.pengiriman');
            Route::get('/pengiriman/{id}/edit', [App\Http\Controllers\Admin\PengirimanController::class, 'edit']);
            Route::post('/pengiriman/kirim', [App\Http\Controllers\Admin\PengirimanController::class, 'kirim'])->name('admin.pengiriman-kirim');

            // menu informasi
            // alamat toko
            Route::get('/alamat-toko', [App\Http\Controllers\Admin\AlamatTokoController::class, 'index'])->name('admin.alamat-toko');
            Route::get('/alamat-toko/{id}/edit', [App\Http\Controllers\Admin\AlamatTokoController::class, 'edit']);
            Route::post('/alamat-toko/update', [App\Http\Controllers\Admin\AlamatTokoController::class, 'update'])->name('admin.alamat-toko-update');

            // review
            Route::get('/review', [App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('admin.review');
            Route::get('/review/{id}/edit', [App\Http\Controllers\Admin\ReviewController::class, 'edit']);
            Route::post('/review/hapus', [App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('admin.review-hapus');

            // event
            Route::get('/event', [App\Http\Controllers\Admin\EventController::class, 'index'])->name('admin.event');
            Route::post('/event/tambah', [App\Http\Controllers\Admin\EventController::class, 'store'])->name('admin.event-tambah');
            Route::get('/event/{id}/edit', [App\Http\Controllers\Admin\EventController::class, 'edit']);
            Route::post('/event/hapus', [App\Http\Controllers\Admin\EventController::class, 'destroy'])->name('admin.event-hapus');
            Route::post('/event/update', [App\Http\Controllers\Admin\EventController::class, 'update'])->name('admin.event-update');

            // menu gudang
            // barang
            Route::get('/barang', [App\Http\Controllers\Admin\BarangController::class, 'index'])->name('admin.barang');
            Route::post('/barang/tambah', [App\Http\Controllers\Admin\BarangController::class, 'store'])->name('admin.barang-tambah');
            Route::get('/barang/{id}/edit', [App\Http\Controllers\Admin\BarangController::class, 'edit']);
            Route::post('/barang/hapus', [App\Http\Controllers\Admin\BarangController::class, 'destroy'])->name('admin.barang-hapus');
            Route::post('/barang/tampilkan', [App\Http\Controllers\Admin\BarangController::class, 'tampilkan'])->name('admin.barang-tampilkan');

            // foto-produk
            Route::get('/foto-produk', [App\Http\Controllers\Admin\FotoProdukController::class, 'index'])->name('admin.foto-produk');
            Route::post('/foto-produk/tambah', [App\Http\Controllers\Admin\FotoProdukController::class, 'store'])->name('admin.foto-produk-tambah');
            Route::get('/foto-produk/{id}/edit', [App\Http\Controllers\Admin\FotoProdukController::class, 'edit']);
            Route::post('/foto-produk/hapus', [App\Http\Controllers\Admin\FotoProdukController::class, 'destroy'])->name('admin.foto-produk-hapus');

            // stok
            Route::get('/stok', [App\Http\Controllers\Admin\BarangController::class, 'indexStok'])->name('admin.stok');

            // menu master
            // kategori
            Route::get('/kategori', [App\Http\Controllers\Admin\KategoriController::class, 'index'])->name('admin.kategori');
            Route::post('/kategori/tambah', [App\Http\Controllers\Admin\KategoriController::class, 'store'])->name('admin.kategori-tambah');
            Route::get('/kategori/{id}/edit', [App\Http\Controllers\Admin\KategoriController::class, 'edit']);
            Route::post('/kategori/hapus', [App\Http\Controllers\Admin\KategoriController::class, 'destroy'])->name('admin.kategori-hapus');

            // user
            Route::get('/user', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.user');
            Route::post('/user/tambah', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.user-tambah');
            Route::get('/user/{id}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit']);
            Route::post('/user/hapus', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.user-hapus');
            Route::patch('/user/update', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.user-update');

            // about
            Route::get('/about', function () {
                return view('about');
            })->name('about');
        });


        Route::get('/account', [App\Http\Controllers\Customer\AccountController::class, 'index'])->name('customer.account');
        Route::post('/update_akun', [App\Http\Controllers\Customer\AccountController::class, 'updateAkun']);
        Route::post('/store_review', [App\Http\Controllers\Customer\DashboardController::class, 'storeReview']);
        Route::get('/konfirmasi_pembayaran/{orderId}', [App\Http\Controllers\Customer\TransaksiController::class, 'konfirmasiPembayaran']);
        Route::get('/konfirmasi-barang-sampai/{orderId}', [App\Http\Controllers\Customer\TransaksiController::class, 'konfirmasi']);
        Route::post('/store_brg_sampai/{orderId}', [App\Http\Controllers\Customer\TransaksiController::class, 'konfirmasiBarangSampai']);

        Route::resource('pre-order', App\Http\Controllers\Customer\PreOrderController::class);
        Route::post('finish-pre-order', [App\Http\Controllers\Customer\PreOrderController::class, 'finishOrder']);
        Route::post('batal-pre-order/{id}', [App\Http\Controllers\Customer\PreOrderController::class, 'batalPreOrder']);
        Route::post('billing-address-pre-order', [App\Http\Controllers\Customer\PreOrderController::class, 'billingPreOrder']);
        Route::post('payment_pre_order', [App\Http\Controllers\Customer\PreOrderController::class, 'bayarSekarang']);
        Route::post('payment_proses_pre_order', [App\Http\Controllers\Customer\PreOrderController::class, 'paymentProsess']);
    }
);

Route::get('/get_kota', [App\Http\Controllers\Customer\AccountController::class, 'getCities']);
Route::get('/about', function () {
    return view('customer.account.about');
});
