<?php

namespace Digiants\FastAdminPanel;

use Digiants\FastAdminPanel\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;


class FastAdminPanelServiceProvider extends ServiceProvider
{

    public function boot() {

        Schema::defaultStringLength(191);

        include __DIR__ . '/routes.php';

        // Register commands
        $this->app->bind('fastadminpanel:install', function ($app) {
            return new \Digiants\FastAdminPanel\Commands\FastAdminPanelInstall();
        });
        $this->commands([
            'fastadminpanel:install'
        ]);

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/fastadminpanel'),
        ], 'fap_public');

        $this->publishes([
            __DIR__.'/views'  => base_path('resources/views/vendor/fastadminpanel'),
        ], 'fap_view');
    }

    public function register() {
        
    }
}