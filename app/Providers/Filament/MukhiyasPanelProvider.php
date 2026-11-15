<?php

namespace App\Providers\Filament;

use App\Filament\App\Pages\ManageProfile;
use App\Filament\Widgets\GameDivisionBreakdownWidget;
use App\Filament\Widgets\MukhiyasHero3DWidget;
use App\Filament\Widgets\MukhiyasStatsOverview;
use App\Filament\Widgets\PlayersRegistrationChart;
use App\Filament\Widgets\RecentPlayersWidget;
use App\Filament\Widgets\RecentTournamentsWidget;
use App\Filament\Widgets\SuperAdminAccessOverviewWidget;
use App\Filament\Widgets\TournamentsStatusChart;
use App\Filament\Widgets\UpcomingMatchesWidget;
use App\Http\Middleware\Authenticate;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class MukhiyasPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('mukhiyas')
            ->path('mukhiyas')
            ->brandLogo(fn () => view('filament.components.brand-logo'))
            ->brandLogoHeight('2.8rem')
            ->favicon(asset('favicon.ico').'?v='.filemtime(public_path('favicon.ico')))
            ->viteTheme('resources/css/filament/mukhiyas/theme.css')
            ->colors([
                'primary' => Color::Orange,
                'amber' => Color::Amber,
            ])
            ->sidebarCollapsibleOnDesktop()
            ->maxContentWidth(Width::Full)
            ->font('Poppins')
            ->navigationGroups([
                NavigationGroup::make('Esports'),
                NavigationGroup::make('People & Access'),
            ])
            ->renderHook(
                PanelsRenderHook::GLOBAL_SEARCH_BEFORE,
                fn () => view('filament.components.topbar-quick-links'),
            )
            ->renderHook(
                PanelsRenderHook::BODY_END,
                fn () => view('filament.components.motion-scripts'),
            )

            ->passwordReset()
            ->emailVerification()
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
                ManageProfile::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                // AccountWidget::class,
                MukhiyasHero3DWidget::class,
                MukhiyasStatsOverview::class,
                GameDivisionBreakdownWidget::class,
                UpcomingMatchesWidget::class,
                SuperAdminAccessOverviewWidget::class,
                RecentTournamentsWidget::class,
                RecentPlayersWidget::class,
                PlayersRegistrationChart::class,
                TournamentsStatusChart::class,
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
                FilamentShieldPlugin::make()
                    ->navigationGroup('People & Access')
                    ->navigationLabel('Roles & Permissions')
                    ->navigationIcon('heroicon-o-key')
                    ->activeNavigationIcon('heroicon-s-key')
                    ->gridColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 3,
                    ])
                    ->sectionColumnSpan(1)
                    ->checkboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 4,
                    ])
                    ->resourceCheckboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                    ]),
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
