<?php

namespace App\Filament\Resources\OwnTeams\Pages;

use App\Filament\Resources\OwnTeams\OwnTeamResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOwnTeam extends CreateRecord
{
    protected static string $resource = OwnTeamResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
