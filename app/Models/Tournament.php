<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\GameType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tournament extends Model
{
    protected $fillable = [
        'name',
        'game',
        'description',
        'prize_pool',
        'status',
        'start_date',
        'end_date',
    ];

    protected function casts(): array
    {
        return [
            'game' => GameType::class,
        ];
    }

    public function gameLabel(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->game?->getLabel() ?? 'Esports Tournament',
        );
    }

    public function isMoba(): bool
    {
        return $this->game?->isMoba() ?? true;
    }

    public function isBattleRoyale(): bool
    {
        return $this->game?->isBattleRoyale() ?? false;
    }

    public function scopeForGame(Builder $query, GameType|string $game): Builder
    {
        $value = $game instanceof GameType ? $game->value : $game;

        return $query->where('game', $value);
    }

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

    public function playerStats(): HasMany
    {
        return $this->hasMany(PlayerTournamentStat::class);
    }

    public function matches(): HasMany
    {
        return $this->hasMany(EsportsMatch::class, 'tournament_id');
    }
}
