<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerTournamentStat extends Model
{
    protected $fillable = [
        'user_id',
        'tournament_id',
        'matches_played',
        'matches_won',
        'matches_lost',
        'kills',
        'deaths',
        'assists',
        'mvps',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }
}
