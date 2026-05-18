<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class OwnTeam extends Model
{
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

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
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
