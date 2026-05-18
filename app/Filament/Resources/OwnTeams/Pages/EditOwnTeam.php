<?php

namespace App\Filament\Resources\OwnTeams\Pages;

use App\Filament\Resources\OwnTeams\OwnTeamResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOwnTeam extends EditRecord
{
    protected static string $resource = OwnTeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
