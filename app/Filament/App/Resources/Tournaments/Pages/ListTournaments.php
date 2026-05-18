<?php

namespace App\Filament\App\Resources\Tournaments\Pages;

use App\Filament\App\Resources\Tournaments\TournamentResource;
use Filament\Resources\Pages\ListRecords;

class ListTournaments extends ListRecords
{
    protected static string $resource = TournamentResource::class;
}
