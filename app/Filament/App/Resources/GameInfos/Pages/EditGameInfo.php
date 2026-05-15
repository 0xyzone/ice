<?php

namespace App\Filament\App\Resources\GameInfos\Pages;

use App\Filament\App\Resources\GameInfos\GameInfoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGameInfo extends EditRecord
{
    protected static string $resource = GameInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
