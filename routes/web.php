<?php

use App\Http\Controllers\PlayerProfileController;
use App\Http\Controllers\TeamProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/player/{id}', [PlayerProfileController::class, 'show'])->name('player.profile');
Route::get('/team/{id}', [TeamProfileController::class, 'show'])->name('team.profile');
