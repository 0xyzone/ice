<?php

use App\Http\Controllers\PlayerProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/player/{id}', [PlayerProfileController::class, 'show'])->name('player.profile');
