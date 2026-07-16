<?php

namespace App\Providers\Filament;

use App\Filament\Admin\Widgets\AdminStatsWidget;
use App\Filament\Admin\Widgets\LoansByCategoryChart;
use App\Filament\Admin\Widgets\MostRequestedBooksChart;
use App\Filament\Dashboard;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->plugins([
                FilamentEditProfilePlugin::make()
                    ->slug('profile')
                    ->setTitle('Editar Perfil')
                    ->setNavigationGroup('Minha Conta')
                    ->setIcon('heroicon-o-user')
            ])
            ->brandName('Bibliotek')

            ->colors([
                'primary' => Color::Hex('#BE123C'),

                'gray' => [
                    50 => '#FDFBF7',
                    100 => '#F4EFE6',
                    200 => '#E6DBCC',
                    300 => '#CFBEAA',
                    400 => '#AB9B90',
                    500 => '#856E61',
                    600 => '#5C4B40',
                    700 => '#3F322A',
                    800 => '#2D1E16',
                    900 => '#1D130D',
                    950 => '#0C0805',
                ],

                'danger'  => Color::Hex('#EF4444'),
                'success' => Color::Hex('#D97706'),
                'warning' => Color::Hex('#FBBF24'),
                'info'    => Color::Hex('#3B82F6'),
            ])

            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\Filament\Admin\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\Filament\Admin\Pages')
            ->pages([
                \App\Filament\Reader\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\Filament\Admin\Widgets')
            ->widgets([
                AdminStatsWidget::class,
                MostRequestedBooksChart::class,
                LoansByCategoryChart::class,
            ])
            ->navigationItems([
                NavigationItem::make('Bibliotek')
                    ->url(url('/'), shouldOpenInNewTab: true)
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->sort(99),
            ])
            ->navigationGroups([
                'Catálogo',
                'Movimentações',
                'Gerenciamento'
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
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
