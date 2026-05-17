<?php

namespace App\Filament\Resources\Admins\Pages;

use App\Filament\Resources\Admins\AdminResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAdmin extends CreateRecord
{
    protected static string $resource = AdminResource::class;

    protected function afterCreate()
    {
        $this->record->assignRole('admin');
        $this->record->email_verified_at = now();
        $this->record->save();
    }
}
