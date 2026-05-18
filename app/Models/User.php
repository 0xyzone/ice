<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password', 'avatar_url'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser, HasAvatar, MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    protected static function booted(): void
    {
        static::deleted(function (User $user) {
            if ($user->avatar_url) {
                Storage::disk('public')->delete($user->avatar_url);
            }
        });

        static::updated(function (User $user) {
            if ($user->isDirty('avatar_url') && $user->getOriginal('avatar_url')) {
                Storage::disk('public')->delete($user->getOriginal('avatar_url'));
            }
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'app') {
            return $this->hasRole('player') || auth()->check();
        } elseif ($panel->getId() === 'mukhiyas') {
            return $this->hasRole(['admin', 'super_admin']) || auth()->check();
        }

        return false;
    }

    public function gameInfos(): HasMany
    {
        return $this->hasMany(GameInfo::class);
    }

    public function player(): HasOne
    {
        return $this->hasOne(PlayerDetail::class);
    }

    public function socials(): HasOne
    {
        return $this->hasOne(UserSocial::class);
    }

    public function teamMemberships(): HasMany
    {
        return $this->hasMany(TeamMember::class, 'user_id');
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? asset('storage/'.$this->avatar_url) : null;
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(UserGallery::class);
    }

    public function legalInfo(): HasOne
    {
        return $this->hasOne(UserLegalInfo::class);
    }
}
