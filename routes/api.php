<?php

use App\Http\Controllers\PlayerLevelController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Player Level Routes
|--------------------------------------------------------------------------
|
| These routes handle player level progression, XP gain, and level rewards.
|
*/

// Get all level configurations
Route::get('/levels', [PlayerLevelController::class, 'getLevels']);

// Get specific level configuration
Route::get('/levels/{level}', [PlayerLevelController::class, 'getLevel']);

// Get player level information
Route::get('/players/{playerId}/level', [PlayerLevelController::class, 'show']);

// Add experience to a player
Route::post('/players/{playerId}/experience', [PlayerLevelController::class, 'addExperience']);

// Get leaderboard
Route::get('/leaderboard', [PlayerLevelController::class, 'leaderboard']);
