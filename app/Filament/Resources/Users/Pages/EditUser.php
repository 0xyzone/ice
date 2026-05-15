<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\PlayerDetail;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getFooterWidgetsColumns(): int|array
    {
        return 1;
    }

    public function getPlayerDetail(): ?PlayerDetail
    {
        return PlayerDetail::query()
            ->where('user_id', $this->record->id)
            ->first();
    }

    protected function getFooterWidgets(): array
    {
        return [];
    }

    public function getViewData(): array
    {
        return [
            'playerDetail' => $this->getPlayerDetail(),
        ];
    }
}
