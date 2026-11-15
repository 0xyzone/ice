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

    /**
     * Sort eager-loaded active members by lineup tier, manual sort_order, and game role rank.
     */
    public function sortMembersRelation(): self
    {
        $teamGame = $this->game;

        $sorted = $this->members
            ->sort(function (TeamMember $a, TeamMember $b) use ($teamGame): int {
                $mainCmp = ($b->is_main_roster ? 1 : 0) <=> ($a->is_main_roster ? 1 : 0);
                if ($mainCmp !== 0) {
                    return $mainCmp;
                }

                $orderCmp = ($a->sort_order ?? PHP_INT_MAX) <=> ($b->sort_order ?? PHP_INT_MAX);
                if ($orderCmp !== 0) {
                    return $orderCmp;
                }

                $rankA = $this->resolveMemberRoleRank($a, $teamGame);
                $rankB = $this->resolveMemberRoleRank($b, $teamGame);
                if ($rankA !== $rankB) {
                    return $rankA <=> $rankB;
                }

                $capCmp = ($a->role === 'captain' ? 0 : 1) <=> ($b->role === 'captain' ? 0 : 1);
                if ($capCmp !== 0) {
                    return $capCmp;
                }

                return ($a->created_at?->getTimestamp() ?? 0) <=> ($b->created_at?->getTimestamp() ?? 0);
            })
            ->values();

        $this->setRelation('members', $sorted);

        return $this;
    }

    private function resolveMemberRoleRank(TeamMember $member, ?GameType $teamGame): int
    {
        $gameInfos = $member->user?->gameInfos;

        if (! $gameInfos || $gameInfos->isEmpty()) {
            return 999;
        }

        $matching = $teamGame
            ? $gameInfos->first(fn (GameInfo $info): bool => $info->game === $teamGame)
            : $gameInfos->first();

        return $matching?->getPrimaryRoleRank() ?? 999;
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
