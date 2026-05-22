<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AlatBeratController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\LokasiProyekController;
use App\Http\Controllers\PricingAlatController;
use App\Http\Controllers\TransaksiSewaController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\DpPembayaranController;
use App\Http\Controllers\HmLogController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login', [AuthController::class, 'index'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);

    // Register
    Route::get('/register', [AuthController::class, 'register'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'store']);

});

/*
|--------------------------------------------------------------------------
| PUBLIC PAGE
|--------------------------------------------------------------------------
*/

Route::get('/', [ProfileController::class, 'index'])
    ->name('profile.index');

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::resource('users', UserController::class);

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::resource('dashboard', DashboardController::class);

    /*
    |--------------------------------------------------------------------------
    | ALAT BERAT
    |--------------------------------------------------------------------------
    */

    Route::resource('alat', AlatBeratController::class);

    /*
    |--------------------------------------------------------------------------
    | OPERATOR
    |--------------------------------------------------------------------------
    */

    Route::resource('operator', OperatorController::class);

    /*
    |--------------------------------------------------------------------------
    | PELANGGAN
    |--------------------------------------------------------------------------
    */

    Route::resource('pelanggan', PelangganController::class);

    /*
    |--------------------------------------------------------------------------
    | LOKASI PROYEK
    |--------------------------------------------------------------------------
    */

    Route::resource('lokasi', LokasiProyekController::class);

    /*
    |--------------------------------------------------------------------------
    | PRICING ALAT
    |--------------------------------------------------------------------------
    */

    Route::resource('pricing', PricingAlatController::class);

    /*
    |--------------------------------------------------------------------------
    | ABOUT
    |--------------------------------------------------------------------------
    */

    Route::resource('about', AboutController::class);

    /*
    |--------------------------------------------------------------------------
    | SERVICE
    |--------------------------------------------------------------------------
    */

    Route::resource('service', ServiceController::class);

    /*
    |--------------------------------------------------------------------------
    | TRANSAKSI SEWA
    |--------------------------------------------------------------------------
    */

    Route::resource('transaksi', TransaksiSewaController::class);

    Route::get('/transaksi/invoice/{id}', [TransaksiSewaController::class, 'printInvoice'])
        ->name('transaksi.invoice');

    Route::get('/transaksi/surat-jalan/{id}', [TransaksiSewaController::class, 'printSuratJalan'])
        ->name('transaksi.surat-jalan');

    /*
    |--------------------------------------------------------------------------
    | TIMESHEET
    |--------------------------------------------------------------------------
    */

    Route::resource('timesheet', TimesheetController::class);

    Route::get('/timesheet/{transaksi}/export', [TimesheetController::class, 'export'])
        ->name('timesheet.export');

    /*
    |--------------------------------------------------------------------------
    | DP PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    Route::resource('dp_pembayaran', DpPembayaranController::class);

    /*
    |--------------------------------------------------------------------------
    | HM LOG
    |--------------------------------------------------------------------------
    */

    Route::resource('hm', HmLogController::class);

});