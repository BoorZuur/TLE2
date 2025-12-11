<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\EnergyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnimalController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;


// home screen
Route::middleware('auth')->get('/', function () {
    return view('home');
})->name('home');

// areas/gebieden
Route::middleware('auth')->get('/areas', function () {
    return view('areas');
})->name('areas');
Route::middleware('auth')->get('/api/collected', [AreaController::class, 'getArea']);
Route::middleware('auth')->get('/api/areas', [AreaController::class, 'getAreas']);

//coins
Route::middleware('auth')->get('/coins', [CoinController::class, 'getCoins'])->name('coins.get');
Route::middleware('auth')->post('/coins/add', [CoinController::class, 'addCoins'])->name('coins.add');

// shop
Route::middleware('auth')->resource('product', ProductController::class);
Route::middleware('auth')->post('/product/{product}/purchase', [ProductController::class, 'purchase'])->name('product.purchase');

//Energy
Route::middleware('auth')->get('/energy', [EnergyController::class, 'getEnergy'])->name('energy.get');
Route::middleware('auth')->post('/energy/add', [EnergyController::class, 'addEnergy'])->name('energy.add');

// Get animal properties
Route::middleware('auth')->get('/animal/{id}/get', [AnimalController::class, 'get'])->name('animal.get');
Route::middleware('auth')->post('/animal/{id}/update', [AnimalController::class, 'update'])->name('animal.update');

// Show user's animal
Route::middleware('auth')->get('/animal/{id}/show', [AnimalController::class, 'show'])->name('animal.show');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/api/animals', [CollectionController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/collectie', function () {
    return view('collection.animals');
})->name('collectie');

require __DIR__ . '/auth.php';
