<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AlatBeratController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\LokasiProyekController;
use App\Http\Controllers\PricingAlatController;
use App\Http\Controllers\TransaksiSewaController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\DpPembayaranController;
use App\Http\Controllers\HmLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;


// Route::get('/', function () {
//     return view('dashboard');
// });

Route::get('/', [ProfileController::class, 'index'])->name('profile.index');


Route::resource('dashboard', DashboardController::class);

// Alat Berat
Route::resource('alat', AlatBeratController::class);

// Operator
Route::resource('operator', OperatorController::class);

// Pelanggan
Route::resource('pelanggan', PelangganController::class);

// Lokasi Proyek
Route::resource('lokasi', LokasiProyekController::class);

// Pricing Alat
Route::resource('pricing', PricingAlatController::class);

// Transaksi Sewa
Route::resource('transaksi', TransaksiSewaController::class);
Route::get('/transaksi/invoice/{id}', [TransaksiSewaController::class, 'printInvoice'])->name('transaksi.invoice');
Route::get('/transaksi/surat-jalan/{id}', [TransaksiSewaController::class, 'printSuratJalan'])->name('transaksi.surat-jalan');

// Timesheet
Route::resource('timesheet', TimesheetController::class);
Route::get('timesheet/{transaksi}/export', [TimesheetController::class, 'export'])
    ->name('timesheet.export');

// DP Pembayaran
Route::resource('dp_pembayaran', DpPembayaranController::class);

// HM Log
Route::resource('hm', HmLogController::class);
