<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\PlayerDetail;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            Action::make('view_public_profile')
                ->label('View Public Profile')
                ->icon('heroicon-o-eye')
                ->color('info')
                ->url(fn (User $user) => $user->username ? route('player.profile.username', $user->username) : route('player.profile', $user->id))
                ->openUrlInNewTab(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
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
