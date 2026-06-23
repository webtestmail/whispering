<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
               $this->app->singleton(\App\Services\SmsService::class, function ($app) {
        return new \App\Services\SmsService();
    });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         View::composer(['user-dashboard.*', 'user-dashboard.components.*'], function ($view) {
            $authUser = Auth::user();

            if (! $authUser instanceof User) {
                return;
            }

            $accountMember = $authUser->getAccountMember();
            $accountMember->loadMissing(['appearance', 'application', 'userprofile']);

            $view->with('authUser', $authUser);
            $view->with('user', $accountMember);
            $view->with('canEditProfile', $authUser->isAccountOwner());
            $view->with('canEditOwnEmail', $authUser->isDashboardSubUser());
            $view->with('canManageUsers', $authUser->canManageUsers());
            $view->with('eventsReadOnly', $authUser->isDashboardSubUser());
        });
 
    }
}
