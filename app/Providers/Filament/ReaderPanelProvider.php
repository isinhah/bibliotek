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
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;

class ReaderPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('reader')
            ->path('reader')
            ->plugins([
                FilamentEditProfilePlugin::make()
                    ->slug('profile')
                    ->setTitle('Editar Perfil')
                    ->setNavigationGroup('Minha Conta')
                    ->setIcon('heroicon-o-user')
            ])
            ->brandName('Bibliotek')
            ->colors([
                'primary' => Color::Hex('#b91c1c'),

                'gray' => Color::Slate,

                'danger' => Color::Rose,
                'info' => Color::Blue,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
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
