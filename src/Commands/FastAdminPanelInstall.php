<?php

namespace Digiants\FastAdminPanel\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Digiants\FastAdminPanel\Templates\TemplateComponents;
use Digiants\FastAdminPanel\Templates\TemplateDefault;
use Artisan;

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
		
		Artisan::call('migrate');
		$this->info('Migrated successfully!');
		
		$this->add_user();
		$type_template = $this->import_template();
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
			$this->path_package('/core/FastAdminPanel'),
			base_path('/app/FastAdminPanel')
		);

		$this->publish_parts_folder(
			$this->path_package('/core/views'),
			base_path('/resources/views/fastadminpanel')
		);

		$this->publish_parts_folder(
			$this->path_package('/core/migrations'),
			base_path('/database/migrations')
		);

		$this->publish_parts_folder(
			$this->path_package('/core/lang'),
			base_path('/lang')
		);

		$this->publish_parts_folder(
			$this->path_package('/public'),
			public_path('/vendor/fastadminpanel')
		);

		copy(
			$this->path_package('/core/routes.php'),
			base_path('/routes/fap.php')
		);

		copy(
			$this->path_package('/core/fap.php'),
			base_path('/config/fap.php')
		);

		// register provider
		$provider = file_get_contents(base_path("/config/app.php"));
		
		if (strpos($provider, 'FAPServiceProvider::class') === false) {

			$pos = strpos($provider, 'Package Service Providers...');
			$pos = strpos($provider, '*/', $pos);
			
			file_put_contents(
				base_path("/config/app.php"),
				substr_replace($provider, '*/ App\FastAdminPanel\Providers\FAPServiceProvider::class,', $pos, 2)
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

	private function add_user() {

		User::create([
			'name'		=> $this->ask('Administrator name'),
			'email'		=> $this->ask('Administrator email'),
			'password'	=> bcrypt($this->secret('Administrator password')),
			'roles_id'	=> 1,
		]);
	}
}