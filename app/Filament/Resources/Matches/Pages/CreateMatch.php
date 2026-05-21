<?php

namespace App\Filament\Resources\Matches\Pages;

use App\Filament\Resources\Matches\MatchResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMatch extends CreateRecord
{
    protected static string $resource = MatchResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
