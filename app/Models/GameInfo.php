<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class GameInfo extends Model
{
    protected static function booted(): void
    {
        static::deleted(function (GameInfo $gameInfo) {
            if ($gameInfo->profile_image) {
                Storage::disk('public')->delete($gameInfo->profile_image);
            }
        });

        static::updated(function (GameInfo $gameInfo) {
            if ($gameInfo->isDirty('profile_image') && $gameInfo->getOriginal('profile_image')) {
                Storage::disk('public')->delete($gameInfo->getOriginal('profile_image'));
            }
        });
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
