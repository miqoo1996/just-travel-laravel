<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            'includes.menu', 'App\Http\ViewComposers\MenuComposer'
        );
        view()->composer(
            '*', 'App\Http\ViewComposers\CurrencyComposer'
        );
        view()->composer(
            'includes.footer_menu', 'App\Http\ViewComposers\FooterMenuComposer'
        );
        view()->composer(
            'includes.hot_tours', 'App\Http\ViewComposers\HotToursComposer'
        );
        view()->composer(
            'admin.layouts.dashboard_layout', 'App\Http\ViewComposers\OrderTourNotificationsComposer'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
