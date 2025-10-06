<?php

namespace Digiants\FastAdminPanel;

use Digiants\FastAdminPanel\Commands\FastAdminPanelInstall;
use Digiants\FastAdminPanel\Commands\FastAdminPanelUninstall;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class FastAdminPanelServiceProvider extends ServiceProvider
{
    public $bindings = [
        'fastadminpanel:install' => FastAdminPanelInstall::class,
        'fastadminpanel:uninstall' => FastAdminPanelUninstall::class,
    ];

    public function boot()
    {
        Schema::defaultStringLength(191);

        $this->commands([
            'fastadminpanel:install',
            'fastadminpanel:uninstall',
        ]);

        // $this->publishes([
        // 	__DIR__.'/../public' => public_path('vendor/fastadminpanel'),
        // ], 'fap_public');

        // $this->publishes([
        // 	__DIR__.'/views'  => base_path('resources/views/fastadminpanel'),
        // ], 'fap_view');
    }

    public function register() {}
}
