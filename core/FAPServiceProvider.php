<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Blade;
use View;
use Convertor;
use Platform;

class FAPServiceProvider extends ServiceProvider
{

	public function boot() {

		$this->app->bind('fastadminpanel:translate', function ($app) {
			return new \App\FastAdminPanel\Commands\FastAdminPanelTranslate();
		});
		
		$this->commands([
			'fastadminpanel:translate',
		]);

		include base_path('/routes/fap.php');

		
		Blade::directive('desktopcss', function () {

            return "<?php ob_start(); ?>";
        });

        Blade::directive('mobilecss', function () {
        
            return '<?php Convertor::create($view_name, ob_get_clean(), true); ob_start(); ?>';
        });

        Blade::directive('endcss', function () {

            return '<?php Convertor::create($view_name, ob_get_clean(), false); ?>';
        });

        Blade::directive('js', function ($index) {
            
            return '<?php $position_js = '.($index ? $index : '1').'; ob_start(); ?>';
        });

        Blade::directive('endjs', function () {

            return '<?php JSAssembler::str($view_name.":".$position_js, ob_get_clean()); ?>';
        });
        
        View::composer('*', function($view){

            $view->with([
                'view_name' => $view->getName(),
            ]);
        });
	}

	public function register() {

		$this->app->booting(function() {
			$loader = AliasLoader::getInstance();
			$loader->alias('JSAssembler', \App\FastAdminPanel\Helpers\JSAssembler::class);
			$loader->alias('Lang', \App\FastAdminPanel\Helpers\Lang::class);
			$loader->alias('ResizeImg', \App\FastAdminPanel\Helpers\ResizeImg::class);
			$loader->alias('Single', \App\FastAdminPanel\Helpers\Single::class);
			$loader->alias('Field', \App\FastAdminPanel\Helpers\Field::class);
			$loader->alias('Platform', \App\FastAdminPanel\Helpers\Platform::class);
			$loader->alias('Convertor', \App\FastAdminPanel\Helpers\Convertor::class);
			$loader->alias('SEO', \App\FastAdminPanel\Helpers\SEO::class);
		});
	}
}