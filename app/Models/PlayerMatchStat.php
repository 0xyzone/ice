<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'hero',
        'total_gold',
        'damage_dealt',
        'turret_damage',
        'damage_taken',
        'survival_time',
        'knockdowns',
        'revives',
        'headshots',
        'extra_stats',
    ];

    protected function casts(): array
    {
        return [
            'kills' => 'integer',
            'deaths' => 'integer',
            'assists' => 'integer',
            'is_mvp' => 'boolean',
            'hero' => 'string',
            'total_gold' => 'integer',
            'damage_dealt' => 'integer',
            'turret_damage' => 'integer',
            'damage_taken' => 'integer',
            'survival_time' => 'integer',
            'knockdowns' => 'integer',
            'revives' => 'integer',
            'headshots' => 'integer',
            'extra_stats' => 'array',
        ];
    }

    public function formattedSurvivalTime(): Attribute
    {
        return Attribute::make(
            get: function (): ?string {
                if ($this->survival_time === null) {
                    return null;
                }
                $minutes = intdiv($this->survival_time, 60);
                $seconds = $this->survival_time % 60;

                return sprintf('%02d:%02d', $minutes, $seconds);
            },
        );
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
