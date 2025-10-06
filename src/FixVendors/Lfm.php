<?php

namespace Digiants\FastAdminPanel\FixVendors;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Lfm
{
    public function fix()
    {
        $this->fixUploadController();
        $this->fixLfmPath();
    }

    protected function fixUploadController()
    {
        $path = base_path('vendor/unisharp/laravel-filemanager/src/Controllers/UploadController.php');

        $content = File::get($path);

        $fixedContent = Str::replace(
            '$response = count($error_bag) > 0 ? $error_bag : parent::$success_response;',
            '$response = count($error_bag) > 0 ? $error_bag : array(parent::$success_response);',
            $content
        );

        File::put($path, $fixedContent);
    }

    protected function fixLfmPath()
    {
        $path = base_path('vendor/unisharp/laravel-filemanager/src/LfmPath.php');

        $content = File::get($path);

        $fixedContent = Str::replace(
            'public function __construct(Lfm $lfm = null)',
            'public function __construct(Lfm $lfm)',
            $content
        );

        File::put($path, $fixedContent);
    }
}
