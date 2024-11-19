<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use App\Livewire\CustomProfileComponent;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;

class ClientPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('client')
            ->path('client')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->login()
            ->registration()
            ->passwordReset()
            ->profile()
            ->discoverResources(in: app_path('Filament/Client/Resources'), for: 'App\\Filament\\Client\\Resources')
            ->discoverPages(in: app_path('Filament/Client/Pages'), for: 'App\\Filament\\Client\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Client/Widgets'), for: 'App\\Filament\\Client\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                FilamentEditProfilePlugin::make()
               // ->slug('my-profile')
                ->setTitle('My Profile')
                ->setNavigationLabel('My Profile')
                ->setNavigationGroup('Group Profile')
                ->setIcon('heroicon-o-user')
                ->setSort(10)
               // ->canAccess(fn () => auth()->user()->id === 1)
                ->shouldRegisterNavigation(false)
                ->shouldShowDeleteAccountForm(false)
               // ->shouldShowSanctumTokens()
                ->shouldShowBrowserSessionsForm(
                  //  fn() => auth()->user()->id === 1, //optional
                        //OR
                    true //optional
                )
                ->shouldShowAvatarForm()
                
            ])
            ->userMenuItems([
    'profile' => MenuItem::make()
        ->label(fn() => auth()->user()->name)
        ->url(fn (): string => EditProfilePage::getUrl())
        ->icon('heroicon-m-user-circle')
        //If you are using tenancy need to check with the visible method where ->company() is the relation between the user and tenancy model as you called
        
]);
    }
}
