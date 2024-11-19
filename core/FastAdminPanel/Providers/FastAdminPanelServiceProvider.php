<?php

namespace App\FastAdminPanel\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use App\FastAdminPanel\Commands\FastAdminPanelTranslate;
use App\FastAdminPanel\Facades\Single as SingleFacade;
use App\FastAdminPanel\Facades\Lang as LangFacade;
use App\FastAdminPanel\Facades\Platform as PlatformFacade;
use App\FastAdminPanel\Helpers\JSAssembler;
use App\FastAdminPanel\Helpers\ResizeImg;
use App\FastAdminPanel\Helpers\Formatter;
use App\FastAdminPanel\Helpers\Convertor;
use App\FastAdminPanel\Helpers\SEO;
use App\FastAdminPanel\Policies\MainPolicy;
use App\FastAdminPanel\Services\LanguageService;
use App\FastAdminPanel\Services\PlatformService;
use App\FastAdminPanel\Single\Single;
use Illuminate\Support\Facades\Gate;
use View;

// TODO: divide this large provider
class FastAdminPanelServiceProvider extends ServiceProvider
{
	public $bindings = [
		'fastadminpanel:translate'	=> FastAdminPanelTranslate::class,
	];
 
    public $singletons = [
        'lang'			=> LanguageService::class,
		'single' 		=> Single::class,
		'platform' 		=> PlatformService::class,
    ];

	// To create custom service - just create your service in app/FastAdminPanel/Services/Crud/Entity/Custom/{$Method}{$Table}Service.php
	// You can check the example \App\FastAdminPanel\Services\Crud\Entity\Custom\ShowProductsService.php (method = show, table = products)

	protected $crudServices = [
		[
			'method'	=> 'index',
			'contract'	=> \App\FastAdminPanel\Contracts\CrudEntity\Index::class,
			'service'	=> \App\FastAdminPanel\Services\Crud\Entity\IndexService::class,
		],
		[
			'method'	=> 'show',
			'contract'	=> \App\FastAdminPanel\Contracts\CrudEntity\Show::class,
			'service'	=> \App\FastAdminPanel\Services\Crud\Entity\ShowService::class,
		],
		[
			'method'	=> 'insertOrUpdate',
			'contract'	=> \App\FastAdminPanel\Contracts\CrudEntity\InsertOrUpdate::class,
			'service'	=> \App\FastAdminPanel\Services\Crud\Entity\InsertOrUpdateService::class,
		],
		[
			'method'	=> 'destroy',
			'contract'	=> \App\FastAdminPanel\Contracts\CrudEntity\Destroy::class,
			'service'	=> \App\FastAdminPanel\Services\Crud\Entity\DestroyService::class,
		],
		[
			'method'	=> 'copy',
			'contract'	=> \App\FastAdminPanel\Contracts\CrudEntity\Copy::class,
			'service'	=> \App\FastAdminPanel\Services\Crud\Entity\CopyService::class,
		],
	];

	public function boot()
	{
		foreach ($this->crudServices as $crudService) {

			$this->app->bind($crudService['contract'], function ($app) use ($crudService) {
	
				$method = $crudService['method'];
				$table = $this->app->request->route('table');
				$customClass = "\\App\\FastAdminPanel\\Services\\Crud\\Entity\\Custom\\{$method}{$table}Service";
				$isCustomClassExists = class_exists($customClass);
				$service = $isCustomClassExists ? $customClass : $crudService['service'];
				return $app->make($service);
			});
		}
		
		$this->commands([
			'fastadminpanel:translate',
		]);

		Blade::directive('desktopcss', function () {

			return "<?php ob_start(); ?>";
		});

		Blade::directive('mobilecss', function () {
		
			return '<?php Convertor::create($viewName, ob_get_clean(), true); ob_start(); ?>';
		});

		Blade::directive('endcss', function () {

			return '<?php Convertor::create($viewName, ob_get_clean(), false); ?>';
		});

		Blade::directive('startjs', function ($index) {
			
			return '<?php $positionJs = '.($index ? $index : '1').'; ob_start(); ?>';
		});

		Blade::directive('endjs', function () {

			return '<?php JSAssembler::str($viewName.":".$positionJs, ob_get_clean()); ?>';
		});
		
		View::composer('*', function($view){

			$view->with([
				'viewName' => $view->getName(),
			]);
		});
		
		Gate::define('everything',		[MainPolicy::class, 'everything']);
		Gate::define('something',		[MainPolicy::class, 'something']);
		Gate::define('show-adminpanel',	[MainPolicy::class, 'showAdminpanel']);

		Route::middleware('web')
		->group(base_path('routes/fap.php'));

		Route::middleware('web')
		->prefix(LangFacade::prefix('', 'fapi'))
		->group(base_path('routes/fapi.php'));
	}

	public function register()
	{
		$this->app->booting(function() {

			$loader = AliasLoader::getInstance();

			$loader->alias('Platform',		PlatformFacade::class);
			$loader->alias('Single',		SingleFacade::class);
			$loader->alias('Lang',			LangFacade::class);
			$loader->alias('JSAssembler',	JSAssembler::class);
			$loader->alias('ResizeImg',		ResizeImg::class);
			$loader->alias('Formatter',		Formatter::class);
			$loader->alias('Convertor',		Convertor::class);
			$loader->alias('SEO',			SEO::class);
		});
	}
}