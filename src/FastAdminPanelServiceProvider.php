<?php

namespace Digiants\FastAdminPanel;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class FastAdminPanelServiceProvider extends ServiceProvider
{

	public function boot() {

		Schema::defaultStringLength(191);

		// Register commands
		$this->app->bind('fastadminpanel:install', function ($app) {
			return new \Digiants\FastAdminPanel\Commands\FastAdminPanelInstall();
		});
		$this->app->bind('newsletter:send', function ($app) {
			return new \Digiants\FastAdminPanel\Commands\NewsletterSend();
		});
		$this->commands([
			'fastadminpanel:install',
			'newsletter:send'
		]);

		// $this->publishes([
		// 	__DIR__.'/../public' => public_path('vendor/fastadminpanel'),
		// ], 'fap_public');

		// $this->publishes([
		// 	__DIR__.'/views'  => base_path('resources/views/fastadminpanel'),
		// ], 'fap_view');
	}

	public function register() {
		
	}
}