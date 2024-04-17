<?php

namespace Digiants\FastAdminPanel\Commands;

use App\Models\User;
use Digiants\FastAdminPanel\Publishers\Core;
use Digiants\FastAdminPanel\Publishers\Provider;
use Digiants\FastAdminPanel\Templates\TemplateImporter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class FastAdminPanelInstall extends Command
{
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
	public function __construct(
		protected TemplateImporter $templateImporter,
		protected Core $publisherCore,
		protected Provider $publisherProvider,
	) {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 */
	public function handle()
	{
		$this->info('Please note: FastAdminPanel requires fresh Laravel installation!');
		
		if (!$this->confirm('Do you wish to continue?')) {

			return Command::FAILURE;
		}

		$this->publisherCore->publish();
		$this->publisherProvider->publish();
		
		Artisan::call('migrate');
		
		$this->addUser();
		$this->importTemplate();

		return Command::SUCCESS;
	}

	protected function importTemplate()
	{
		$isImport = $this->confirm('Import template (only on fresh installation): converter, layout, header, footer, pagination, JS, route, SitemapController, PagesController?');

		if ($isImport) {

			$type = $this->choice('Which type of template do you want?', [
				TemplateImporter::DEFAULT,
				TemplateImporter::COMPONENTS,
			]);

			$this->templateImporter->import($type);
		}
	}

	protected function addUser()
	{
		User::create([
			'name'		=> $this->ask('Administrator name'),
			'email'		=> $this->ask('Administrator email'),
			'password'	=> bcrypt($this->secret('Administrator password')),
			'roles_id'	=> 1,
		]);
	}
}