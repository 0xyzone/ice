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
        'status',
        'joined_at',
        'left_at',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(OwnTeam::class, 'own_team_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
