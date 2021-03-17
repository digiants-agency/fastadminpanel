<?php

namespace Digiants\FastAdminPanel\Commands;

use Digiants\FastAdminPanel\Helpers\Single;
use App\User;
use Illuminate\Console\Command;
use Schema;
use DB;

class FastAdminPanelInstall extends Command {

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'fastadminpanel:install';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Run installation of FastAdminPanel.';

	/**
	 * Create a new command instance.
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 */
	public function handle() {
		$this->info('Please note: FastAdminPanel requires fresh Laravel installation! If you failed installation just clear your DB.');
		$this->add_languages();
		$this->create_db();
		$this->add_roles();
		$this->add_user();
		$this->add_menu();
		$this->import_default_template();
	}

	private function template_add_folder ($path) {

		if (!is_dir($path)) {
			mkdir($path);
		}
	}

	private function template_path_package ($path) {

		return base_path("/vendor/sv-digiants/fastadminpanel/template".$path);
	}

	private function import_default_template () {

		$answer = $this->ask('Import default template (only on fresh installation): converter, layout, header, footer, pagination, JS, route, SitemapController, PagesController, View Composer (Y/n)?');

		if ($answer != 'n') {

			// add converter
			$this->template_add_folder(public_path('/css'));
			$css = [
				'converter-desktop.php', 
				'converter-mobile.php',
				'desktop-src.css',
				'mobile-src.css',
				'desktop.css',
				'mobile.css',
			];
			foreach ($css as $path) {
				copy(
					$this->template_path_package("/css/$path"),
					public_path("/css/$path")
				);
			}
			// add views
			$this->template_add_folder(base_path('/resources/views/inc'));
			$this->template_add_folder(base_path('/resources/views/layouts'));
			$this->template_add_folder(base_path('/resources/views/pages'));
			$views = [
				'layouts/app.blade.php',
				'inc/footer.blade.php',
				'inc/header.blade.php',
				'inc/head.blade.php',
				'inc/pagination.blade.php',
				'pages/index.blade.php',
			];
			foreach ($views as $path) {
				copy(
					$this->template_path_package("/views/$path"),
					base_path("/resources/views/$path")
				);
			}
			// routes
			if (file_exists(base_path("/routes/web.php")))
				unlink(base_path("/routes/web.php"));
			copy(
				$this->template_path_package("/web.php"),
				base_path("/routes/web.php")
			);
			// controllers
			copy(
				$this->template_path_package("/SitemapController.php"),
				base_path("/app/Http/Controllers/SitemapController.php")
			);
			copy(
				$this->template_path_package("/PagesController.php"),
				base_path("/app/Http/Controllers/PagesController.php")
			);
			// view composer
			$composer = 
		'\\View::composer(["inc.header","inc.footer"], function ($view) {
		
			// 

			$view->with([

			]);
		});';
			$provider = file_get_contents(base_path("/app/Providers/AppServiceProvider.php"));
			$pos = strrpos($provider, '//');
			
			file_put_contents(
				base_path("/app/Providers/AppServiceProvider.php"),
				substr_replace($provider, $composer, $pos, 2)
			);
			
			// rm default view
			if (file_exists(base_path("/resources/views/welcome.blade.php")))
				unlink(base_path("/resources/views/welcome.blade.php"));
		}
	}

	private function create_db() {

		Single::create_db($this);

		if (!Schema::hasTable('dropdown')) {
			Schema::create('dropdown', function (\Illuminate\Database\Schema\Blueprint $table) {
				$table->increments('id');
				$table->string('title')->default('');
				$table->integer('sort')->default(0);
			});
		} else {
			$this->info('Dropdown table has already exist!');
		}
		
		if (!Schema::hasTable('users')) {
			Schema::create('users', function (\Illuminate\Database\Schema\Blueprint $table) {
				$table->bigIncrements('id');
				$table->string('name');
				$table->integer('id_roles')->default(1);
				$table->string('email')->unique();
				$table->timestamp('email_verified_at')->nullable();
				$table->string('password');
				$table->rememberToken();
				$table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
				$table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
				$table->timestamp('deleted_at')->nullable();
			});
		} else {
			$this->info('Users table has already exist!');
		}

		if (!Schema::hasTable('roles')) {
			Schema::create('roles', function (\Illuminate\Database\Schema\Blueprint $table) {
				$table->increments('id');
				$table->string('title');
				$table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
				$table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
			});
		} else {
			$this->info('Roles table has already exist!');
		}

		if (!Schema::hasTable('menu')) {
			Schema::create('menu', function (\Illuminate\Database\Schema\Blueprint $table) {
				$table->increments('id');
				$table->string('title');
				$table->string('table_name');
				$table->text('fields');
				$table->integer('is_dev');
				$table->integer('multilanguage');
				$table->integer('is_soft_delete');
				$table->integer('sort');
				$table->integer('parent')->default(0);
				$table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
				$table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
			});
		} else {
			$this->info('Menu table has already exist!');
		}

		$this->info('DB creation complete!');
	}

	private function add_roles() {

		DB::table('roles')->insert([
			'title' => 'Administrator'
		]);
		DB::table('roles')->insert([
			'title' => 'User'
		]);
	}

	private function add_languages() {

		if (!Schema::hasTable('languages')) {
			Schema::create('languages', function (\Illuminate\Database\Schema\Blueprint $table) {
				$table->increments('id');
				$table->string('tag');
				$table->integer('main_lang');
			});
		} else {
			$this->info('Languages table has already exist!');
		}

		$count = $this->ask('Languages count');
		if ($count > 0) {
			$id = $this->ask('ID of main language from 0 to '.($count - 1));

			for ($i = 0; $i < $count; $i++) {
				DB::table('languages')->insert([
					'tag' => $this->ask("Language tag number $i"),
					'main_lang' => ($id == $i) ? 1 : 0,
				]);
			}

			$this->info('If you missclicked with something, you can repair it in table languages');
		}
	}

	private function add_user() {

		$data = [];
		$data['name']     = $this->ask('Administrator name');
		$data['email']    = $this->ask('Administrator email');
		$data['password'] = bcrypt($this->secret('Administrator password'));
		$data['id_roles']  = 1;
		User::create($data);
		$this->info('User has been created');
	}

	private function add_menu() {

		DB::table('menu')->insert([
			'title'             => 'Menu',
			'table_name'        => 'menu',
			'fields'            => '[]',
			'is_dev'            => '1',
			'multilanguage'     => '0',
			'is_soft_delete'    => '0',
			'sort'              => '0',
		]);
		DB::table('menu')->insert([
			'title'             => 'Roles',
			'table_name'        => 'roles',
			'fields'            => '[{"id":0,"required":"optional","is_visible":true,"show_in_list":"yes","type":"text","db_title":"title","title":"Title"}]',
			'is_dev'            => '1',
			'multilanguage'     => '0',
			'is_soft_delete'    => '0',
			'sort'              => '1',
		]);
		DB::table('menu')->insert([
			'title'             => 'Users',
			'table_name'        => 'users',
			'fields'            => '[{"id":0,"lang":0,"required":"optional","is_visible":true,"show_in_list":"yes","type":"text","db_title":"name","title":"Name"},{"id":1,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"relationship","relationship_count":"single","relationship_table_name":"roles","title":"Role","relationship_view_field":"title"},{"id":2,"lang":0,"required":"optional","is_visible":true,"show_in_list":"yes","type":"text","db_title":"email","title":"Email"},{"id":3,"lang":0,"required":"optional","is_visible":true,"show_in_list":"no","type":"password","db_title":"password","title":"Password"}]',
			'is_dev'            => '0',
			'multilanguage'     => '0',
			'is_soft_delete'    => '0',
			'sort'              => '2',
		]);
		$this->info('Menu has been created');
	}
}