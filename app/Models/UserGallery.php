<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class UserGallery extends Model
{
    protected $fillable = [
        'user_id',
        'image_path',
        'caption',
    ];

    protected static function booted(): void
    {
        static::deleted(function (UserGallery $gallery) {
            if ($gallery->image_path) {
                Storage::disk('public')->delete($gallery->image_path);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
