<?php

namespace Digiants\FastAdminPanel;

use Digiants\FastAdminPanel\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

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
            __DIR__.'/views'  => base_path('resources/views/fastadminpanel'),
        ], 'fap_view');
    }

    public function register() {

        // require_once __DIR__ . '/Helpers/JSAssembler.php';
        // require_once __DIR__ . '/Helpers/Lang.php';
        // require_once __DIR__ . '/Helpers/ResizeImg.php';
        // require_once __DIR__ . '/Helpers/Translater.php';

        $this->app->booting(function() {
            $loader = AliasLoader::getInstance();
            $loader->alias('JSAssembler', \Digiants\FastAdminPanel\Helpers\JSAssembler::class);
            $loader->alias('Lang', \Digiants\FastAdminPanel\Helpers\Lang::class);
            $loader->alias('ResizeImg', \Digiants\FastAdminPanel\Helpers\ResizeImg::class);
            $loader->alias('Tr', \Digiants\FastAdminPanel\Helpers\Translater::class);
        });
    }
}