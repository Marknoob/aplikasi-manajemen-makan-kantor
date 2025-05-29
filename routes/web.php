<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenusController;
use App\Http\Controllers\MenusDeckController;
use App\Http\Controllers\MenusDeckExpensesController;
use App\Http\Controllers\MenusDeckPaymentsController;
use App\Http\Controllers\MenusRecomenderController;
use App\Http\Controllers\VendorsController;

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

// Dashboard
Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware(['auth', 'verified']);
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware(['auth', 'verified']);
Route::get('/dashboard/pengeluaran', [DashboardController::class, 'pengeluaran'])
    ->name('dashboard.pengeluaran')
    ->middleware(['auth', 'verified']);
Route::get('/dashboard/pembayaran', [DashboardController::class, 'pembayaran'])
    ->name('dashboard.pembayaran')
    ->middleware(['auth', 'verified']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Master
Route::resource('menus', MenusController::class)->middleware(['auth', 'verified']);
Route::resource('vendors', VendorsController::class)->middleware(['auth', 'verified']);



// Transaksi
Route::resource('menus-deck', MenusDeckController::class)->middleware(['auth', 'verified']);
Route::resource('menus-recommender', MenusRecomenderController::class)->middleware(['auth', 'verified']);
Route::resource('menus-deck-expenses', MenusDeckExpensesController::class)->middleware(['auth', 'verified']);
Route::resource('menus-deck-payments', MenusDeckPaymentsController::class)->middleware(['auth', 'verified']);


require __DIR__.'/auth.php';
