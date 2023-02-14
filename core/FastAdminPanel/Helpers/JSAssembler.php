<?php 

namespace App\FastAdminPanel\Helpers;

use App\FastAdminPanel\Helpers\JSAssembler as FastAdminPanelHelpersJSAssembler;
use Digiants\FastAdminPanel\Helpers\JSAssembler as HelpersJSAssembler;
use Route;

class JSAssembler
{
    private static $js_file = [[],[],[]];
    private static $js_str = [[],[],[]];

    private static $script = '';

    public static function add($path, $index = 1)
	{
        JSAssembler::$js_file[$index][] = public_path().$path;
    }

    public static function str($view, $script, $index = 1)
	{
        $parts = explode(':', $view);

        if (sizeof($parts) == 2)
            $index = intval($parts[1]);
        else {
            $index = 1;
        }

        $tags = ['<script>', '</script>'];
        
        JSAssembler::$js_str[$index][$parts[0]] = str_replace($tags, ['', ''], $script);
    }
    
    public static function get()
	{
        // need research of version collision

        if (isset(request()->route()->getAction()['controller']))
            $method = request()->route()->getAction()['controller'];
        else 
            $method = '404';

        $page_name = strtolower(
            str_replace(
                [
                    'App\Http\Controllers\\', 
                    '@', 
                    'Controller'
                ], 
                [
                    '', 
                    '_',
                    ''
                ], 
                $method
            )
        );

        $cache_path = public_path().'/js/cache/'.$page_name.'.js';
        
        if (!file_exists(dirname($cache_path))) {
            mkdir(dirname($cache_path));
        }

        if (!file_exists($cache_path)) {
            file_put_contents($cache_path, '');
        }
        
        $time_source = filemtime($cache_path);

        $compressed = '';
            
        $is_cache_file = true;

        foreach (JSAssembler::$js_file as $arr) {
            foreach ($arr as $file) {
                if (filemtime($file) > $time_source) {
                    
                    $is_cache_file = false;
                    break;
                }
            }
        }
        
        $components_dir = resource_path().'/views/';
    
        $is_cache_str = true;

        if (file_exists($cache_path)){

            foreach (JSAssembler::$js_str as $js_str_index){
                
                foreach ($js_str_index as $key => $js_str_item){

                    $key = str_replace('.', '/', $key);

                    $time_component = filemtime($components_dir.$key.'.blade.php');
                    
                    if ($time_component > $time_source){
                        $is_cache_str = false;
                        break;
                    }
                }

            }
        } else {
            $is_cache_str = false;
        }
        

        if (!$is_cache_file || !$is_cache_str){

            foreach (JSAssembler::$js_file as $arr) {
                foreach ($arr as $file) {
                    $compressed .= file_get_contents($file).';'.PHP_EOL;
                }
            }

            foreach (JSAssembler::$js_str as &$js_str_index){

                foreach($js_str_index as $js_str_item){
                    JSAssembler::$script .= ' '.$js_str_item.';'.PHP_EOL;
                }
        
            }


            $compressed .= JSAssembler::$script;
                
            file_put_contents($cache_path, $compressed);
        }
            
            
        
        echo "<script src=\"/js/cache/".$page_name.".js?v=".filemtime('js/cache/'.$page_name.'.js')."\" ></script>";
    }
}