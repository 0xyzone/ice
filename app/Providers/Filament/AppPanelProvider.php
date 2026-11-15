<?php

namespace App\Providers\Filament;

use App\Filament\App\Widgets\PlayerGameAccountsWidget;
use App\Filament\App\Widgets\PlayerHero3DWidget;
use App\Filament\App\Widgets\PlayerProfileLinkWidget;
use App\Filament\App\Widgets\PlayerStatsOverviewWidget;
use App\Filament\App\Widgets\PlayerTeamsWidget;
use App\Filament\App\Widgets\PlayerTimelineWidget;
use App\Filament\App\Widgets\PlayerTournamentsWidget;
use App\Filament\App\Widgets\PlayerUpcomingMatchesWidget;
use App\Filament\App\Widgets\PlayerWinsLossesChart;
use App\Http\Middleware\Authenticate;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('app')
            ->path('app')
            ->brandLogo(fn () => view('filament.components.brand-logo'))
            ->brandLogoHeight('2.8rem')
            ->favicon(asset('favicon.ico').'?v='.filemtime(public_path('favicon.ico')))
            ->viteTheme('resources/css/filament/app/theme.css')
            ->colors([
                'primary' => Color::Orange,
                'amber' => Color::Amber,
            ])
            ->sidebarCollapsibleOnDesktop()
            ->maxContentWidth(Width::Full)
            ->font('Poppins')
            ->renderHook(
                PanelsRenderHook::GLOBAL_SEARCH_BEFORE,
                fn () => view('filament.components.topbar-quick-links'),
            )
            ->renderHook(
                PanelsRenderHook::BODY_END,
                fn () => view('filament.components.motion-scripts'),
            )

            // ->registration()
            ->profile()
            ->passwordReset()
            ->emailVerification()
            ->discoverResources(in: app_path('Filament/App/Resources'), for: 'App\Filament\App\Resources')
            ->discoverPages(in: app_path('Filament/App/Pages'), for: 'App\Filament\App\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/App/Widgets'), for: 'App\Filament\App\Widgets')
            ->widgets([
                // AccountWidget::class,
                PlayerHero3DWidget::class,
                PlayerStatsOverviewWidget::class,
                PlayerGameAccountsWidget::class,
                PlayerUpcomingMatchesWidget::class,
                PlayerProfileLinkWidget::class,
                PlayerTeamsWidget::class,
                PlayerTournamentsWidget::class,
                PlayerWinsLossesChart::class,
                PlayerTimelineWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->plugins([
                // FilamentShieldPlugin::make(),
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
