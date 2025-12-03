<?php

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

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

Route::prefix('api')->group(function () {
    Route::get('/animals', [CollectionController::class, 'index']);
});

Route::get('/collectie', function () {
    return view('collection.animals');
})->name('collectie');

require __DIR__ . '/auth.php';
