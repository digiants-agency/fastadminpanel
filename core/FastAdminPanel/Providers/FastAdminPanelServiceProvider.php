<?php

namespace App\FastAdminPanel\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use App\FastAdminPanel\Commands\FastAdminPanelTranslate;
use App\FastAdminPanel\Facades\Single as SingleFacade;
use App\FastAdminPanel\Facades\Lang as LangFacade;
use App\FastAdminPanel\Helpers\JSAssembler;
use App\FastAdminPanel\Helpers\ResizeImg;
use App\FastAdminPanel\Helpers\Field;
use App\FastAdminPanel\Helpers\Platform;
use App\FastAdminPanel\Helpers\Convertor;
use App\FastAdminPanel\Helpers\SEO;
use App\FastAdminPanel\Services\LanguageService;
use App\FastAdminPanel\Single\Single as Single;
use View;

// TODO: divide this large provider
class FastAdminPanelServiceProvider extends ServiceProvider
{
	public $bindings = [
    ];
 
    public $singletons = [
        'lang' 		=> LanguageService::class,
		'single' 	=> Single::class,
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
			->group(base_path('routes/fastadminpanel.php'));

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

		Route::middleware('api')
		->prefix('api')
		->group(base_path('routes/fastadminpanel_api.php'));
	}

	public function register()
	{
		$this->app->booting(function() {

			$loader = AliasLoader::getInstance();

			$loader->alias('Single', 		SingleFacade::class);
			$loader->alias('Lang', 			LangFacade::class);
			$loader->alias('JSAssembler', 	JSAssembler::class);
			$loader->alias('ResizeImg', 	ResizeImg::class);
			$loader->alias('Field', 		Field::class);
			$loader->alias('Platform', 		Platform::class);
			$loader->alias('Convertor', 	Convertor::class);
			$loader->alias('SEO', 			SEO::class);
		});
	}
}