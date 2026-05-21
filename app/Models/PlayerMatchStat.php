<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerMatchStat extends Model
{
    protected $table = 'player_match_stats';

    protected $fillable = [
        'match_series_id',
        'user_id',
        'kills',
        'deaths',
        'assists',
        'is_mvp',
        'extra_stats',
    ];

    protected function casts(): array
    {
        return [
            'kills' => 'integer',
            'deaths' => 'integer',
            'assists' => 'integer',
            'is_mvp' => 'boolean',
            'extra_stats' => 'array',
        ];
    }

    public function matchSeries(): BelongsTo
    {
        return $this->belongsTo(MatchSeries::class, 'match_series_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
