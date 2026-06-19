<?php

namespace App\Providers\Filament;

use App\Filament\Dashboard;
use App\Filament\Reader\Widgets\ReaderStatsWidget;
use App\Filament\Reader\Widgets\ReaderWelcomeWidget;
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

class ReaderPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('reader')
            ->path('reader')
            ->brandName('Bibliotek')
            ->colors([
                'primary' => [
                    50 => '#fef2f2', 100 => '#fee2e2', 200 => '#fecaca', 300 => '#fca5a5',
                    400 => '#f87171', 500 => '#ef4444', 600 => '#dc2626', 700 => '#b91c1c',
                    800 => '#991b1b', 900 => '#7f1d1d', 950 => '#450a0a',
                ],
                'success' => [
                    50 => '#ecfdf5', 100 => '#d1fae5', 200 => '#a7f3d0', 300 => '#6ee7b7',
                    400 => '#34d399', 500 => '#10b981', 600 => '#059669', 700 => '#047857',
                    800 => '#065f46', 900 => '#064e3b', 950 => '#022c22',
                ],
                'warning' => Color::Amber,
                'danger' => Color::Rose
            ])
            ->discoverResources(in: app_path('Filament/Reader/Resources'), for: 'App\Filament\Reader\Resources')
            ->discoverPages(in: app_path('Filament/Reader/Pages'), for: 'App\Filament\Reader\Pages')
            ->pages([
                \App\Filament\Reader\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Reader/Widgets'), for: 'App\Filament\Reader\Widgets')
            ->widgets([
                ReaderStatsWidget::class,
            ])
            ->navigationItems([
                NavigationItem::make('Bibliotek')
                    ->url(url('/'), shouldOpenInNewTab: true)
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->sort(99),
            ])
            ->navigationGroups([
                'Catálogos',
                'Empréstimos',
                'Gerenciamento',
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
