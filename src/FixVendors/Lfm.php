<?php

namespace Digiants\FastAdminPanel\FixVendors;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Lfm
{
    public function fix()
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
}
