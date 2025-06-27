<?php
use App\Models\HauraDokter;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HauraDokterController;

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
Route::delete('/login', [HauraDokterController::class, 'destroy'])->name('dokter.destroy');
Route::post('login', [AuthController::class, 'login']);

