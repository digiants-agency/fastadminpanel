<?php

namespace App\FastAdminPanel\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use App\FastAdminPanel\Commands\FastAdminPanelTranslate;
use App\FastAdminPanel\Single\Single;
use App\FastAdminPanel\Facades\Lang;
use App\FastAdminPanel\Helpers\JSAssembler;
use App\FastAdminPanel\Helpers\ResizeImg;
use App\FastAdminPanel\Helpers\Field;
use App\FastAdminPanel\Helpers\Platform;
use App\FastAdminPanel\Helpers\Convertor;
use App\FastAdminPanel\Helpers\SEO;
use App\FastAdminPanel\Services\LanguageService;
use App\FastAdminPanel\Services\FastAdminPanelService;
use View;

// TODO: divide this large provider
class FAPServiceProvider extends ServiceProvider
{
	public $bindings = [
    ];
 
    public $singletons = [
        'lang' => LanguageService::class,
    ];

	public function boot()
	{
		$this->app->bind('fastadminpanel:translate', function ($app) {
			return new FastAdminPanelTranslate();
		});
		
		$this->commands([
			'fastadminpanel:translate',
		]);

		Route::middleware('web')
			->group(base_path('routes/fap.php'));

		Blade::directive('desktopcss', function () {

			return "<?php ob_start(); ?>";
		});

		Blade::directive('mobilecss', function () {
		
			return '<?php Convertor::create($view_name, ob_get_clean(), true); ob_start(); ?>';
		});

		Blade::directive('endcss', function () {

			return '<?php Convertor::create($view_name, ob_get_clean(), false); ?>';
		});

		Blade::directive('startjs', function ($index) {
			
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

	public function register()
	{
		$this->app->booting(function() {

			$loader = AliasLoader::getInstance();

			$fastAdminPanelService = $this->app->make(FastAdminPanelService::class);

			if ($fastAdminPanelService->isSingleSaving()) {

				$loader->alias('Single', \App\FastAdminPanel\Single\Saver\Single::class);

			} else {

				$loader->alias('Single', Single::class);
			}

			$loader->alias('Lang', 			Lang::class);
			$loader->alias('JSAssembler', 	JSAssembler::class);
			$loader->alias('ResizeImg', 	ResizeImg::class);
			$loader->alias('Field', 		Field::class);
			$loader->alias('Platform', 		Platform::class);
			$loader->alias('Convertor', 	Convertor::class);
			$loader->alias('SEO', 			SEO::class);
		});
	}
}