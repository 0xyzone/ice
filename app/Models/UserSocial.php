<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSocial extends Model
{
    protected $fillable = [
        'user_id',
        'facebook',
        'instagram',
        'snapchat',
        'discord',
        'linkedin',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
