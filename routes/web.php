<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermitWorkController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\RoleMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route untuk halaman login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route untuk dashboard utama
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Group route berdasarkan role pengguna
Route::middleware(['auth', 'role:pemohon'])->group(function () {
    // Route untuk pemohon izin
    Route::get('/permit-works', [PermitWorkController::class, 'index'])->name('permit-works.index');
    Route::get('/permit-works/create', [PermitWorkController::class, 'create'])->name('permit-works.create');
    Route::post('/permit-works', [PermitWorkController::class, 'store'])->name('permit-works.store');
    Route::get('/permit-works/{id}', [PermitWorkController::class, 'show'])->name('permit-works.show');
    Route::get('/permit-works/{id}/edit', [PermitWorkController::class, 'edit'])->name('permit-works.edit');
    Route::put('/permit-works/{id}', [PermitWorkController::class, 'update'])->name('permit-works.update');
    Route::delete('/permit-works/{id}', [PermitWorkController::class, 'destroy'])->name('permit-works.destroy');
});

Route::middleware(['auth', 'role:verifikator'])->group(function () {
    // Route untuk verifikator
    Route::get('/permit-works/verify', [PermitWorkController::class, 'indexVerify'])->name('permit-works.verify');
    Route::post('/permit-works/verify/{id}', [PermitWorkController::class, 'verify'])->name('permit-works.verify.process');
});

Route::middleware(['auth', 'role:supervisor'])->group(function () {
    // Route untuk supervisor
    Route::get('/permit-works/report', [PermitWorkController::class, 'report'])->name('permit-works.report');
});
