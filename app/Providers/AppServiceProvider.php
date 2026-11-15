<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Responses\LogoutResponse;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LogoutResponseContract::class, LogoutResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();

        DatePicker::configureUsing(function (DatePicker $component): void {
            $component->firstDayOfWeek(0);
        });

        // Globally configure Create, Edit, and View actions to open in Slide-Overs
        CreateAction::configureUsing(fn (CreateAction $action): CreateAction => $action->slideOver());
        EditAction::configureUsing(fn (EditAction $action): EditAction => $action->slideOver());
        ViewAction::configureUsing(fn (ViewAction $action): ViewAction => $action->slideOver());
    }
}
