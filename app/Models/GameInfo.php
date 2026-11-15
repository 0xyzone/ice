<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\GameType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class GameInfo extends Model
{
    protected $fillable = [
        'user_id',
        'game',
        'in_game_id',
        'in_game_username',
        'server_id',
        'role',
        'device_type',
        'main_heroes',
        'profile_image',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'game' => GameType::class,
            'main_heroes' => 'array',
            'status' => 'boolean',
        ];
    }

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

    public function gameLabel(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->game?->getLabel() ?? 'Game Account',
        );
    }

    public function roleLabel(): Attribute
    {
        return Attribute::make(
            get: function (): ?string {
                if (! $this->role || ! $this->game) {
                    return $this->role;
                }
                $roles = $this->game->getRoles();

                return $roles[$this->role] ?? $this->role;
            },
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
