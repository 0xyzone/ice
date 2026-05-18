<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Game extends Model
{
    protected static function booted(): void
    {
        static::deleted(function (Game $game) {
            if ($game->game_banner) {
                Storage::disk('public')->delete($game->game_banner);
            }
            if ($game->game_logo) {
                Storage::disk('public')->delete($game->game_logo);
            }
        });

        static::updated(function (Game $game) {
            if ($game->isDirty('game_banner') && $game->getOriginal('game_banner')) {
                Storage::disk('public')->delete($game->getOriginal('game_banner'));
            }
            if ($game->isDirty('game_logo') && $game->getOriginal('game_logo')) {
                Storage::disk('public')->delete($game->getOriginal('game_logo'));
            }
        });
    }

    public function gameInfos(): HasMany
    {
        return $this->hasMany(GameInfo::class);
    }

    public function ownTeams(): HasMany
    {
        return $this->hasMany(OwnTeam::class);
    }
}
