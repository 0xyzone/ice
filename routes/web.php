<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PlayerProfileController;
use App\Http\Controllers\TeamProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/player/{id}', [PlayerProfileController::class, 'show'])->name('player.profile')->where('id', '[0-9]+');
Route::get('/player/{username}', [PlayerProfileController::class, 'showByUsername'])->name('player.profile.username');

Route::get('/team/{id}', [TeamProfileController::class, 'show'])->name('team.profile')->where('id', '[0-9]+');
Route::get('/team/{slug}', [TeamProfileController::class, 'showBySlug'])->name('team.profile.slug');

use App\Models\OwnTeam;
use App\Models\TeamMember;
use App\Models\Tournament;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    $teams = OwnTeam::with(['game', 'members.user.player'])->where('status', true)->get();

    $squadsCount = OwnTeam::where('status', true)->count();
    $athletesCount = TeamMember::where('status', true)->count();
    $tournamentsCount = Tournament::count();

    $totalMatches = DB::table('tournament_team')->sum('matches_played');
    $wonMatches = DB::table('tournament_team')->sum('matches_won');
    $winRate = $totalMatches > 0 ? round(($wonMatches / $totalMatches) * 100, 1) : 0;

    $members = TeamMember::with(['user.player', 'team'])
        ->whereHas('user')
        ->orderByRaw("CASE WHEN role = 'captain' THEN 0 ELSE 1 END")
        ->orderBy('created_at')
        ->get();

    return view('welcome', compact('teams', 'squadsCount', 'athletesCount', 'tournamentsCount', 'winRate', 'members'));
});

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::redirect('/app/login', '/login');
Route::redirect('/mukhiyas/login', '/login');
