<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class UserLegalInfo extends Model
{
    protected $fillable = [
        'user_id',
        'citizenship_number',
        'citizenship_front_image',
        'citizenship_back_image',
        'citizenship_issued_date',
        'citizenship_issued_place',
        'passport_number',
        'passport_image',
        'passport_issued_date',
        'passport_expiry_date',
        'passport_issued_place',
        'nid_number',
        'nid_image',
        'nid_issued_date',
        'nid_issued_place',
        'pan_number',
        'pan_image',
        'ssf_number',
        'ssf_image',
        'driving_license_number',
        'driving_license_image',
    ];

    protected static function booted(): void
    {
        $imageFields = [
            'citizenship_front_image',
            'citizenship_back_image',
            'passport_image',
            'nid_image',
            'pan_image',
            'ssf_image',
            'driving_license_image',
        ];

        static::deleted(function (UserLegalInfo $legalInfo) use ($imageFields) {
            foreach ($imageFields as $field) {
                if ($legalInfo->$field) {
                    Storage::disk('public')->delete($legalInfo->$field);
                }
            }
        });

        static::updated(function (UserLegalInfo $legalInfo) use ($imageFields) {
            foreach ($imageFields as $field) {
                if ($legalInfo->isDirty($field) && $legalInfo->getOriginal($field)) {
                    Storage::disk('public')->delete($legalInfo->getOriginal($field));
                }
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
