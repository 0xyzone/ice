<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tournament extends Model
{
    protected $fillable = [
        'name',
        'description',
        'prize_pool',
        'status',
        'start_date',
        'end_date',
    ];

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(OwnTeam::class, 'tournament_team')
            ->withPivot([
                'matches_played',
                'matches_won',
                'matches_lost',
                'points',
                'rank',
            ])
            ->withTimestamps();
    }
}
