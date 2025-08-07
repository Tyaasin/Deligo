<?php

// use App\Http\Controllers\AdminAuthController;
// use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\AdminTransaksiController;
use App\Http\Controllers\AdminPesananDetailController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\pelanggan\PelangganController;
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

Route::get('/', [AdminAuthController::class, 'index'])->name('login');

Route::get('/login', [AdminAuthController::class, 'index'])->name('login');
Route::post('/login', [AdminAuthController::class, 'store'])->name('login.store');
Route::post('/register', [AdminAuthController::class, 'register'])->name('register.store');
Route::get('/logout', [AdminAuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::prefix('/pelanggan')->middleware(['auth', 'role:pelanggan'])->group(function () {
    Route::get('/pages', [PelangganController::class, 'index'])->name('pelanggan.pages');

    // Buat pesanan (jika pelanggan boleh create pesanan)
    Route::get('/pesanan', [PelangganController::class, 'pesanan'])->name('pelanggan.pesanan');
    Route::post('/pesanan', [PelangganController::class, 'storePesanan'])->name('pelanggan.pesanan.store');

    Route::get('/bayar/{pesanan}', [PelangganController::class, 'formBayar'])->name('pelanggan.bayar');
    Route::post('/bayar/{pesanan}', [PelangganController::class, 'prosesBayar'])->name('pelanggan.bayar.proses');
    Route::post('/batal/{pesanan}', [PelangganController::class, 'batalBayar'])->name('pelanggan.batal');
});

Route::prefix('/kasir')->middleware(['auth', 'role:kasir'])->group(function () {
    Route::get('/transaksi', [KasirController::class, 'index'])->name('kasir.transaksi.index');
    Route::get('/transaksi/{pesanan}/bayar', [KasirController::class, 'formBayar'])->name('kasir.transaksi.bayar');
    Route::post('/transaksi/{pesanan}/bayar', [KasirController::class, 'prosesBayar'])->name('kasir.transaksi.proses');
    Route::get('/riwayat', [KasirController::class, 'riwayat'])->name('kasir.riwayat.riwayat');
});

Route::prefix('/admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/pages', [AdminAuthController::class, 'dashboard'])->name('admin.pages');

    // Route::resource('/kategori', AdminKategoriController::class);
    Route::resource('/produk', AdminProdukController::class);
    Route::resource('/user', AdminUserController::class);
    Route::resource('/transaksi', AdminTransaksiController::class);
    Route::resource('/transaksi/detail', AdminPesananDetailController::class);

    // Laporan Penjualan
    Route::get('/laporan', [App\Http\Controllers\AdminLaporanPenjualanController::class, 'index'])->name('admin.laporan');
    Route::post('/laporan/generate', [App\Http\Controllers\AdminLaporanPenjualanController::class, 'generate'])->name('admin.laporan.generate');
    Route::get('/laporan/export-csv', [App\Http\Controllers\AdminLaporanPenjualanController::class, 'exportCsv'])->name('admin.laporan.csv');
});


// Route::prefix('/admin')->middleware('auth')->group(function () {
//     Route::get('/pages', function () {
//         $data = [
//             'content'   => 'admin.pages'
//         ];
//         return view('admin.layouts.wrapper', $data);
//     });

// Route::get('/pelanggan/pages', [pelangganController::class, 'index'])->name('pelanggan.pages');

// Route::prefix('/kasir')->middleware(['auth', 'role:kasir'])->group(function () {
//     Route::get('/index', function () {
//         $data = [
//             'content' => 'kasir.index'
//         ];
//             return view('kasir.index', $data);
//         });
//     });

//     Route::resource('/transaksi/detail', AdminPesananDetailController::class);
//     Route::resource('/transaksi', AdminTransaksiController::class);
//     Route::resource('/produk', AdminProdukController::class);
//     Route::resource('/kategori', AdminKategoriController::class);
//     Route::resource('/user', AdminUserController::class);
// });
