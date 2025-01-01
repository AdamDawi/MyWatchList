<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WatchListController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/watchlist', [WatchlistController::class, 'index'])->name('watchlist');
    Route::post('/watchlist', [WatchlistController::class, 'add'])->name('watchlist.add');
    Route::patch('/watchlist/{movie}', [WatchlistController::class, 'update'])->name('watchlist.update');
    Route::delete('/watchlist/{movie}', [WatchlistController::class, 'remove'])->name('watchlist.remove');
});

require __DIR__.'/auth.php';
