<?php

namespace Digiants\FastAdminPanel\Publishers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProviderRemover
{
    public function remove()
    {
        $providers = File::get(base_path('/bootstrap/providers.php'));
        $newProviders = Str::replaceMatches('/[^\n]+FastAdminPanelServiceProvider::class,\r*\n/', '', $providers);
        File::put(base_path('/bootstrap/providers.php'), $newProviders);
    }
}
