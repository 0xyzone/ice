<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MatchSeries extends Model
{
    protected $table = 'match_series';

    protected $fillable = [
        'match_id',
        'game_number',
        'map_name',
        'result',
        'win_condition',
        'placement',
        'placement_points',
        'kill_points',
        'total_points',
        'our_score',
        'opponent_score',
        'did_we_win',
    ];

    protected function casts(): array
    {
        return [
            'game_number' => 'integer',
            'our_score' => 'integer',
            'opponent_score' => 'integer',
            'placement' => 'integer',
            'placement_points' => 'integer',
            'kill_points' => 'integer',
            'total_points' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (MatchSeries $series) {
            // If `did_we_win` virtual attribute is present (from form toggle), use it explicitly
            if (! is_null($series->did_we_win)) {
                $series->result = $series->did_we_win ? 'won' : 'lost';
                unset($series->did_we_win);
            } elseif ($series->placement !== null) {
                // For Battle Royale, 1st place is considered won / WWCD / Booyah
                $series->result = $series->placement === 1 ? 'won' : 'lost';
            } else {
                // Fallback: auto-determine from scores
                if ($series->our_score > $series->opponent_score) {
                    $series->result = 'won';
                } elseif ($series->our_score < $series->opponent_score) {
                    $series->result = 'lost';
                } else {
                    $series->result = 'draw';
                }
            }
        });

        static::saved(function (MatchSeries $series): void {
            if ($match = $series->match) {
                $match->recalculateScores();
            }
        });

        static::deleted(function (MatchSeries $series): void {
            if ($match = $series->match) {
                $match->recalculateScores();
            }
        });
    }

    public function match(): BelongsTo
    {
        return $this->belongsTo(EsportsMatch::class, 'match_id');
    }

    public function playerStats(): HasMany
    {
        return $this->hasMany(PlayerMatchStat::class, 'match_series_id');
    }
}
