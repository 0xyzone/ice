<?php

namespace App\Filament\Resources\OwnTeams\Pages;

use App\Filament\Resources\OwnTeams\OwnTeamResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOwnTeams extends ListRecords
{
    protected static string $resource = OwnTeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
