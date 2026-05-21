<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function players(Request $request)
    {
        $players = TeamMember::with(['team', 'user'])->get();

        return response()->json([
            'status' => 'success',
            'data' => $players->transform(function ($player) {
                return [
                    'id' => $player->user_id,
                    'name' => $player->user->name,
                    'bio' => $player->user->player->bio,
                    'username' => $player->user->username,
                    'email' => $player->user->email,
                    'avatar' => $player->user->avatar_full_url,
                    'jersey_number' => $player->jersey_number,
                    'position' => $player->position,
                    'team' => [
                        'id' => $player->team->id,
                        'name' => $player->team->name,
                        'logo' => $player->team->logo,
                    ],
                ];
            }),
        ]);
    }
}
