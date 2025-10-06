<?php

namespace Digiants\FastAdminPanel\Commands;

use Digiants\FastAdminPanel\Publishers\CoreRemover;
use Digiants\FastAdminPanel\Publishers\ProviderRemover;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class FastAdminPanelUninstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fastadminpanel:uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete FastAdminPanel installation files.';

    /**
     * Create a new command instance.
     */
    public function __construct(
        protected CoreRemover $coreRemover,
        protected ProviderRemover $providerRemover,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (! $this->confirm('Do you wish to continue?')) {

            return Command::FAILURE;
        }

        Artisan::call('migrate:reset');

        $this->coreRemover->remove();
        $this->providerRemover->remove();
        // TODO: remove template

        return Command::SUCCESS;
    }
}
