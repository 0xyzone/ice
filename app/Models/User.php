<?php

namespace App\Models;

use App\Models\GameInfo;
use App\Models\PlayerDetail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail, FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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
            return true;
        } elseif ($panel->getId() === 'mukhiyas') {
            return str_ends_with($this->email, '@suminshrestha.com.np') || str_ends_with($this->email, '@admin.com') || str_ends_with($this->email, '@vidantaca.com.np');
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
}
