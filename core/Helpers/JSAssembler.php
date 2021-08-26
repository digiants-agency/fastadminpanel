<?php 

namespace App\FastAdminPanel\Helpers;

use Route;

class JSAssembler {

    private static $js = [[],[],[]];

    public static function add ($path, $index = 1) {
        JSAssembler::$js[$index][] = public_path().$path;
    }

    public static function get () {

        // need research of version collision

        if (empty(Route::getCurrentRoute()))
            return;
        
        $page_name = explode('@', Route::getCurrentRoute()->getActionName())[1];

        $cache_path = public_path()."/js/cache/$page_name.js";

        $id = 0;
        $count = 0;

        foreach (JSAssembler::$js as $arr) {
            foreach ($arr as $file) {
                $id += filemtime($file);
                $count++;
            }
        }

        $ver = (int)($id / $count);

        if (!file_exists(dirname($cache_path))) {
            mkdir(dirname($cache_path));
        }

        if (!file_exists($cache_path)) {
            file_put_contents($cache_path, '');
        }

        if (filemtime($cache_path) != $ver) {

            $compressed = '';
            
            foreach (JSAssembler::$js as $arr) {
                foreach ($arr as $file) {
                    $compressed .= file_get_contents($file).';
';
                }
            }
        
            file_put_contents($cache_path, $compressed);
            
            touch($cache_path, $ver);
        }

        echo "<script src=\"/js/cache/$page_name.js?v=$ver\" defer></script>";
    }
}