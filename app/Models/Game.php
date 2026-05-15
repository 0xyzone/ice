<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    public function gameInfos(): HasMany
    {
        return $this->hasMany(GameInfo::class);
    }

    public function ownTeams(): HasMany
    {
        return $this->hasMany(OwnTeam::class);
    }
}
