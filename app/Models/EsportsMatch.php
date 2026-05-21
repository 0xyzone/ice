<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EsportsMatch extends Model
{
    protected $table = 'matches';

    protected $fillable = [
        'tournament_id',
        'own_team_id',
        'opponent_name',
        'opponent_logo',
        'match_date',
        'status',
        'stage',
        'best_of',
        'our_score',
        'opponent_score',
    ];

    protected function casts(): array
    {
        return [
            'match_date' => 'datetime',
            'best_of' => 'integer',
            'our_score' => 'integer',
            'opponent_score' => 'integer',
        ];
    }

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    public function ownTeam(): BelongsTo
    {
        return $this->belongsTo(OwnTeam::class, 'own_team_id');
    }

    public function series(): HasMany
    {
        return $this->hasMany(MatchSeries::class, 'match_id');
    }

    public function recalculateScores(): void
    {
        $wonMaps = $this->series()->where('result', 'won')->count();
        $lostMaps = $this->series()->where('result', 'lost')->count();

        $this->updateQuietly([
            'our_score' => $wonMaps,
            'opponent_score' => $lostMaps,
        ]);
    }
}
