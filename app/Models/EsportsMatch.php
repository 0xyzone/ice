<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EsportsMatch extends Model
{
    protected $table = 'matches';

    protected $fillable = [
        'tournament_id',
        'match_type',
        'own_team_id',
        'opponent_name',
        'opponent_logo',
        'match_date',
        'status',
        'stage',
        'best_of',
        'our_score',
        'opponent_score',
        'placement',
        'placement_points',
        'kill_points',
        'total_points',
        'is_winner',
    ];

    protected function casts(): array
    {
        return [
            'match_date' => 'datetime',
            'best_of' => 'integer',
            'our_score' => 'integer',
            'opponent_score' => 'integer',
            'placement' => 'integer',
            'placement_points' => 'integer',
            'kill_points' => 'integer',
            'total_points' => 'integer',
            'is_winner' => 'boolean',
        ];
    }

    public function isBattleRoyale(): bool
    {
        return $this->match_type === 'battle_royale_round'
            || ($this->tournament && $this->tournament->isBattleRoyale());
    }

    public function isMoba(): bool
    {
        return ! $this->isBattleRoyale();
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
        if ($this->isBattleRoyale()) {
            $totalPts = (int) $this->series()->sum('total_points');
            $bestPlacement = $this->series()->whereNotNull('placement')->min('placement');
            $isWinner = $this->series()->where('result', 'won')->exists() || $bestPlacement === 1;

            $this->updateQuietly([
                'total_points' => $totalPts,
                'placement' => $bestPlacement,
                'is_winner' => $isWinner,
            ]);
        } else {
            $wonMaps = $this->series()->where('result', 'won')->count();
            $lostMaps = $this->series()->where('result', 'lost')->count();

            $this->updateQuietly([
                'our_score' => $wonMaps,
                'opponent_score' => $lostMaps,
            ]);
        }
    }
}
