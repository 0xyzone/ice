<?php

use App\Http\Controllers\PlayerProfileController;
use App\Http\Controllers\TeamProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/player/{id}', [PlayerProfileController::class, 'show'])->name('player.profile')->where('id', '[0-9]+');
Route::get('/player/{username}', [PlayerProfileController::class, 'showByUsername'])->name('player.profile.username');

Route::get('/team/{id}', [TeamProfileController::class, 'show'])->name('team.profile')->where('id', '[0-9]+');
Route::get('/team/{slug}', [TeamProfileController::class, 'showBySlug'])->name('team.profile.slug');
