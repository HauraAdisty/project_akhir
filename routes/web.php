<?php

use App\Models\HauraDokter;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HauraDokterController;
use App\Http\Controllers\HauraJadwalController;
use App\Http\Controllers\HauraBookingController;

// Route::get('/', function () {
//     return view('welcome');
//});
Route::get('/', [HauraDokterController::class, 'index'])->name('home');
Route::get('/dokter', [HauraDokterController::class, 'list'])->name('dokter.list_dokter');
Route::get('/dokter/create', [HauraDokterController::class, 'create'])->name('dokter.form_dokter');
Route::post('/dokter', [HauraDokterController::class, 'store'])->name('dokter.store');
Route::get('/dokter/{id}', [HauraDokterController::class, 'show'])->name('dokter.show');
Route::put('/dokter/{id}', [HauraDokterController::class, 'update'])->name('dokter.update');
Route::delete('/dokter/{id}', [HauraDokterController::class, 'destroy'])->name('dokter.destroy');
// Route::post('login', [AuthController::class, 'login']);

// Dashboard akan menampilkan halaman booking yang berbeda untuk admin dan pasien
Route::get('/dashboard', [HauraBookingController::class, 'index'])->name('dashboard');

//Login
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


// Route untuk Pasien membuat booking
Route::get('/bookings/create', [HauraBookingController::class, 'create'])->name('bookings.create');
Route::post('/bookings', [HauraBookingController::class, 'store'])->name('bookings.store');
Route::get('/bookings', [HauraBookingController::class, 'index'])->name('bookings.index');
Route::patch('/bookings/{booking}/status', [HauraBookingController::class, 'updateStatus'])->name('bookings.updateStatus');

// Route untuk Admin melihat semua booking dan mengubah statusnya
Route::get('/bookings', [HauraBookingController::class, 'index'])->name('bookings.index');
Route::patch('/bookings/{booking}/status', [HauraBookingController::class, 'updateStatus'])->name('bookings.updateStatus');

Route::get('/dokter/{dokter}/jadwal', [HauraJadwalController::class, 'showByDokter'])->name('dokter.jadwal');
