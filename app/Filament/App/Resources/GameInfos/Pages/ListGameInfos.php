<?php

namespace App\Filament\App\Resources\GameInfos\Pages;

use App\Filament\App\Resources\GameInfos\GameInfoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGameInfos extends ListRecords
{
    protected static string $resource = GameInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
