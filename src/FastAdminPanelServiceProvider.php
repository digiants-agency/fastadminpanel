<?php

namespace Digiants\FastAdminPanel;

use Digiants\FastAdminPanel\Commands\FastAdminPanelInstall;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class FastAdminPanelServiceProvider extends ServiceProvider
{
	public function boot()
	{
		Schema::defaultStringLength(191);

		$this->app->bind('fastadminpanel:install', function ($app) {
			return $app->make(FastAdminPanelInstall::class);
		});
		$this->commands([
			'fastadminpanel:install',
		]);

		// $this->publishes([
		// 	__DIR__.'/../public' => public_path('vendor/fastadminpanel'),
		// ], 'fap_public');

		// $this->publishes([
		// 	__DIR__.'/views'  => base_path('resources/views/fastadminpanel'),
		// ], 'fap_view');
	}

	public function register()
	{
		
	}
}