<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'total_damage',
        'total_points',
        'avg_survival_time',
    ];

    protected function casts(): array
    {
        return [
            'matches_played' => 'integer',
            'matches_won' => 'integer',
            'matches_lost' => 'integer',
            'kills' => 'integer',
            'deaths' => 'integer',
            'assists' => 'integer',
            'mvps' => 'integer',
            'total_damage' => 'integer',
            'total_points' => 'integer',
            'avg_survival_time' => 'integer',
        ];
    }

    public function formattedAvgSurvivalTime(): Attribute
    {
        return Attribute::make(
            get: function (): ?string {
                if ($this->avg_survival_time === null) {
                    return null;
                }
                $minutes = intdiv($this->avg_survival_time, 60);
                $seconds = $this->avg_survival_time % 60;

                return sprintf('%02d:%02d', $minutes, $seconds);
            },
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }
}
