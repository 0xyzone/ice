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
        'roles',
        'device_type',
        'main_heroes',
        'profile_image',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'game' => GameType::class,
            'roles' => 'array',
            'main_heroes' => 'array',
            'status' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (GameInfo $gameInfo): void {
            $roles = is_array($gameInfo->roles) ? array_values(array_filter($gameInfo->roles)) : [];

            if (empty($roles) && filled($gameInfo->role)) {
                $roles = [$gameInfo->role];
            }

            if (! empty($roles) && $gameInfo->game instanceof GameType) {
                $game = $gameInfo->game;
                usort($roles, fn (string $a, string $b): int => $game->getRoleRank($a) <=> $game->getRoleRank($b));
                $roles = array_values(array_unique($roles));
            }

            $gameInfo->roles = $roles ?: null;
            $gameInfo->role = $roles[0] ?? $gameInfo->role;
        });

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
                $labels = $this->getRoleLabels();

                return empty($labels) ? null : implode(', ', $labels);
            },
        );
    }

    /**
     * @return array<int, string>
     */
    public function getRoleLabels(): array
    {
        $roles = is_array($this->roles) && ! empty($this->roles)
            ? $this->roles
            : (filled($this->role) ? [$this->role] : []);

        if (empty($roles)) {
            return [];
        }

        $roleMap = $this->game?->getRoles() ?? [];

        return array_values(array_map(
            fn (string $r): string => $roleMap[$r] ?? ($r === 'rusher' ? 'Primary Rusher' : ucfirst(str_replace('_', ' ', $r))),
            $roles
        ));
    }

    public function getPrimaryRoleRank(): int
    {
        $roles = is_array($this->roles) && ! empty($this->roles)
            ? $this->roles
            : (filled($this->role) ? [$this->role] : []);

        if (empty($roles) || ! $this->game instanceof GameType) {
            return 999;
        }

        return min(array_map(fn (string $r): int => $this->game->getRoleRank($r), $roles));
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
