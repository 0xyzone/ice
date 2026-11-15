<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamMember extends Model
{
    protected $fillable = [
        'own_team_id',
        'user_id',
        'role',
        'is_main_roster',
        'sort_order',
        'status',
        'joined_at',
        'left_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_main_roster' => 'boolean',
            'sort_order' => 'integer',
            'status' => 'boolean',
            'joined_at' => 'date',
            'left_at' => 'date',
        ];
    }

    public function isMainRoster(): bool
    {
        return (bool) $this->is_main_roster;
    }

    public function scopeMainRoster($query)
    {
        return $query->where('is_main_roster', true);
    }

    public function scopeReserves($query)
    {
        return $query->where('is_main_roster', false);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(OwnTeam::class, 'own_team_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
