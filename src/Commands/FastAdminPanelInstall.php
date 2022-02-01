<?php

namespace Digiants\FastAdminPanel\Commands;

use App\FastAdminPanel\Helpers\Single;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Digiants\FastAdminPanel\ShopTemplates\ShopTemplateBahroma;
use Digiants\FastAdminPanel\ShopTemplates\ShopTemplateDTG;
use Digiants\FastAdminPanel\Templates\TemplateComponents;
use Digiants\FastAdminPanel\Templates\TemplateDefault;

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
		$this->info('Please note: FastAdminPanel requires fresh Laravel installation!');
		$this->publish_parts();
		$this->add_languages();
		$this->create_db();
		$this->add_roles();
		$this->add_user();
		$this->add_menu();
		$type_template = $this->import_template();
		$this->import_shop($type_template);
	}

	private function template_add_folder ($path) {

		if (!is_dir($path)) {
			mkdir($path, 0777, true);
		}
	}

	private function path_package ($path) {

		return base_path("/vendor/sv-digiants/fastadminpanel" . $path);
	}

	private function publish_parts_folder ($source, $destination) {

		$this->template_add_folder($destination);

		$files = scandir($source);

		foreach ($files as $file) {

			if ($file == '.' || $file == '..')
				continue;

			if (is_dir($source . '/' . $file)) {

				$this->publish_parts_folder($source . '/' . $file, $destination . '/' . $file);

			} else {

				copy(
					$source . '/' . $file,
					$destination . '/' . $file
				);
			}
		}
	}

	private function publish_parts () {

		$this->publish_parts_folder(
			$this->path_package('/core/Commands'),
			base_path('/app/FastAdminPanel/Commands')
		);

		$this->publish_parts_folder(
			$this->path_package('/core/Controllers'),
			base_path('/app/FastAdminPanel/Controllers')
		);

		$this->publish_parts_folder(
			$this->path_package('/core/Helpers'),
			base_path('/app/FastAdminPanel/Helpers')
		);

		$this->publish_parts_folder(
			$this->path_package('/core/Middleware'),
			base_path('/app/FastAdminPanel/Middleware')
		);

		$this->publish_parts_folder(
			$this->path_package('/core/views'),
			base_path('/resources/views/fastadminpanel')
		);

		$this->publish_parts_folder(
			$this->path_package('/public'),
			public_path('/vendor/fastadminpanel')
		);

		copy(
			$this->path_package('/core/FAPServiceProvider.php'),
			base_path('/app/Providers/FAPServiceProvider.php')
		);

		copy(
			$this->path_package('/core/routes.php'),
			base_path('/routes/fap.php')
		);

		// register provider
		$provider = file_get_contents(base_path("/config/app.php"));
		
		if (strpos($provider, 'FAPServiceProvider::class') === false) {

			$pos = strpos($provider, 'Package Service Providers...');
			$pos = strpos($provider, '*/', $pos);
			
			file_put_contents(
				base_path("/config/app.php"),
				substr_replace($provider, '*/ App\Providers\FAPServiceProvider::class,', $pos, 2)
			);
		}
	}

	private function import_template () {

		$answer = $this->ask('Import template (only on fresh installation): converter, layout, header, footer, pagination, JS, route, SitemapController, PagesController (Y/n)?');

		$type = '';

		if ($answer != 'n') {

			$type = $this->choice('Which type of template do you want?', [
				'Default',
				'With Components',
			]);

			if ($type == 'Default'){
				$template = new TemplateDefault();
			} else {
				$template = new TemplateComponents();
			}

			$template->import();
			
		}

		return $type;
	}

	private function import_shop($type){

		if (empty($type))
			return;

		$answer = $this->ask('Import shop template (if previous been yes) (Y/n)?');

		if ($answer != 'n') {

			if ($type == 'Default'){
				$shop_template = new ShopTemplateBahroma();

				$status = $shop_template->import_shop();
	
			} else {
				$shop_template = new ShopTemplateDTG();

				$status = $shop_template->import_shop();
	
			}

			$this->info($status);	
		}
	}

	private function create_db() {

		Single::create_db($this);

		if (!Schema::hasTable('dropdown')) {
			Schema::create('dropdown', function (\Illuminate\Database\Schema\Blueprint $table) {
				$table->increments('id');
				$table->string('title')->default('');
				$table->integer('sort')->default(0);
				$table->string('icon')->default('')->nullable();
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
				$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
				$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
				$table->timestamp('deleted_at')->nullable();
			});
		} else {
			$this->info('Users table has already exist!');
		}

		if (!Schema::hasTable('roles')) {
			Schema::create('roles', function (\Illuminate\Database\Schema\Blueprint $table) {
				$table->increments('id');
				$table->string('title');
				$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
				$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
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
				$table->string('icon')->default('')->nullable();
				$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
				$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
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