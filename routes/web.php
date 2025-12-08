<?php

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnimalController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;


// home screen -> linked to homecontroller for getting animal
Route::middleware('auth')->get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->get('/areas', function () {
    return view('areas');
})->name('areas');

// feeding get/post
Route::get('/animal/{animal}/hunger', [AnimalController::class, 'getHunger'])
    ->name('animal.hunger.get');
Route::post('/animal/{animal}/feed', [AnimalController::class, 'feed'])
    ->name('animal.feed');


//coins
Route::middleware('auth')->get('/coins', [CoinController::class, 'getCoins'])->name('coins.get');
Route::middleware('auth')->post('/coins/add', [CoinController::class, 'addCoins'])->name('coins.add');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->resource('shop', ProductController::class);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('api')->group(function () {
    Route::get('/animals', [CollectionController::class, 'index']);
});

Route::get('/collectie', function () {
    return view('collection.animals');
})->name('collectie');

require __DIR__ . '/auth.php';
