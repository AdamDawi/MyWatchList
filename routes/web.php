<?php

use App\Http\Controllers\MovieController;
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
})->name('welcome');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    // Nadanie nazw '->name' pomaga w odwoływaniu się do reguł
    Route::get('/watchlist', [WatchlistController::class, 'index'])->name('watchlist');
    Route::post('/watchlist', [WatchlistController::class, 'add'])->name('watchlist.add');
    Route::patch('/watchlist/{movie}', [WatchlistController::class, 'update'])->name('watchlist.update');
    Route::delete('/watchlist/{movie}', [WatchlistController::class, 'remove'])->name('watchlist.remove');
    //TODO edit this
    Route::get('/watchlist/movie/{movie}', [MovieController::class, 'movieDetails'])->name('movie.details');
});

Route::middleware('auth')->group(function () {
    Route::get('/movies/search', [MovieController::class, 'search'])->name('movies.search');
    Route::post('/movies/search', [MovieController::class, 'addFromSearch']);
});

require __DIR__.'/auth.php';
