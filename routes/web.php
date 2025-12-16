<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnimalOverviewController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\EnergyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnimalController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;


// home screen -> linked to homecontroller for getting animal
Route::get('/', [HomeController::class, 'index'])->name('home');

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

Route::get('/collection', [CollectionController::class, 'collection'])->name('collection.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/collectie', function () {
    $species = \App\Models\Specie::with('habitat')->where('status', 1)->get();
    return view('collection.animals', compact('species'));
})->name('collectie')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/animals', [AnimalOverviewController::class, 'index'])
        ->name('animals.index');
});


// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

// Species management
    Route::get('/admin/species/create', [CollectionController::class, 'create'])->name('admin.species.create');
    Route::post('/admin/species', [CollectionController::class, 'store'])->name('admin.species.store');
    Route::patch('/species/{specie}/toggle-status', [CollectionController::class, 'toggleStatus'])->name('species.toggleStatus');
    Route::get('/admin/species/{specie}/edit', [CollectionController::class, 'edit'])->name('admin.species.edit');
    Route::put('/admin/species/{specie}', [CollectionController::class, 'update'])->name('admin.species.update');
    Route::get('/admin/species', [CollectionController::class, 'dashboard'])->name('admin.species.index');
    Route::post('/admin/species', [CollectionController::class, 'store'])->name('admin.species.store');
});

require __DIR__ . '/auth.php';
