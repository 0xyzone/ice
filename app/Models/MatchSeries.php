<?php

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
        'our_score',
        'opponent_score',
    ];

    protected function casts(): array
    {
        return [
            'game_number' => 'integer',
            'our_score' => 'integer',
            'opponent_score' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (MatchSeries $series) {
            if ($series->our_score > $series->opponent_score) {
                $series->result = 'won';
            } elseif ($series->our_score < $series->opponent_score) {
                $series->result = 'lost';
            } else {
                $series->result = 'draw';
            }
        });

        static::saved(function (MatchSeries $series) {
            if ($match = $series->match) {
                $match->recalculateScores();
            }
        });

        static::deleted(function (MatchSeries $series) {
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
