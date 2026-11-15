<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\GameType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OwnTeam extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'game' => GameType::class,
            'status' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (OwnTeam $ownTeam) {
            if (empty($ownTeam->slug) && ! empty($ownTeam->name)) {
                $ownTeam->slug = Str::slug($ownTeam->name);
            }
        });

        static::deleted(function (OwnTeam $ownTeam) {
            if ($ownTeam->logo_image) {
                Storage::disk('public')->delete($ownTeam->logo_image);
            }
        });

        static::updated(function (OwnTeam $ownTeam) {
            if ($ownTeam->isDirty('logo_image') && $ownTeam->getOriginal('logo_image')) {
                Storage::disk('public')->delete($ownTeam->getOriginal('logo_image'));
            }
        });
    }

    public function gameLabel(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->game?->getLabel() ?? 'Esports Division',
        );
    }

    public function scopeForGame(Builder $query, GameType|string $game): Builder
    {
        $value = $game instanceof GameType ? $game->value : $game;

        return $query->where('game', $value);
    }

    public function members(): HasMany
    {
        return $this->hasMany(TeamMember::class, 'own_team_id');
    }

    public function tournaments(): BelongsToMany
    {
        return $this->belongsToMany(Tournament::class, 'tournament_team')
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
