<?php

namespace App\FastAdminPanel\Helpers;

use App\FastAdminPanel\Helpers\Platform;
use Route;

class Convertor
{

    private static $width_mobile = 320;
    private static $width_desktop = 1440;

    private static $style_source_path_mobile = 'css/mobile-src.css';
    private static $style_source_path_desktop = 'css/desktop-src.css';


    public static $views = [];

    public static function create($view, $style){

        $style = self::remove_style($style);
                
        self::$views[$view] = $style;

    }


    public static function convert(){
        
        $cache_dir = public_path()."/css/cache";
        $css_dir = "/css/cache";
        
        $components_dir = resource_path().'/views/';

        if (isset(request()->route()->getAction()['controller']))
            $method = request()->route()->getAction()['controller'];
        else {
            $method = '404';
        }
        
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

        if ( Platform::mobile() || Platform::tablet() ){
            
            // $page_name .= '_mobile';
            $style_src = self::$style_source_path_mobile;
            $page_css = $cache_dir.'/'.$page_name.'_mobile.css';

        } else {

            $style_src = self::$style_source_path_desktop;
            $page_css = $cache_dir.'/'.$page_name.'.css';

        }


        $is_cache = true;

        if (file_exists($page_css)){

            $time_source = filemtime($page_css);
            foreach (self::$views as $key => $view){

                $key = str_replace('.', '/', $key);

                $time_component = filemtime($components_dir.$key.'.blade.php');
                
                $time_css = filemtime($style_src);

                if ($time_component > $time_source || $time_css > $time_source){

                    $is_cache = false;
                }
            }
        } else {
            $is_cache = false;
        }

        if ($is_cache){
    	    return "<link rel='stylesheet' href='".$css_dir."/".$page_name.".css'>
            <link rel='stylesheet' href='".$css_dir."/".$page_name."_mobile.css'>";
        }

        $width = ( Platform::mobile() || Platform::tablet() ) ? self::$width_mobile : self::$width_desktop;

        $styles = '';
        
        if (Platform::mobile())
            $styles .= self::add_tablet_media();
        
        if (Platform::mobile()){
            $styles .= '@media (max-width: calc(900px)) { ';
        } else {
            $styles .= '@media (min-width: calc(900px)) { ';
        }

        $styles .= file_get_contents($style_src);


        foreach (self::$views as $view){
            $styles .= ' '.$view;
        }

        $styles .= ' }';

        preg_match_all('/[ :]{1}[-]{0,1}[0-9\.]+px/', $styles, $matches);

        for ($i = 0; $i < count($matches[0]); $i++) {

            if ($matches[0][$i] == ' 1px' || $matches[0][$i] == ' 2px' || $matches[0][$i] == ' 3px' || $matches[0][$i] == ' -1px' || $matches[0][$i] == ' -2px' || $matches[0][$i] == ' -3px')
                continue;

            $val = floatval($matches[0][$i]);

            $vw = round($val / $width * 100, 4);

            if (Platform::mobile())
    		    $styles = str_replace($matches[0][$i], ' calc('.$vw.'vw * var(--coef-w))', $styles);
            else 
                $styles = str_replace($matches[0][$i], ' '.$vw.'vw', $styles);
            
        }


        file_put_contents($page_css, $styles);

        return "<link rel='stylesheet' href='".$css_dir."/".$page_name.".css'>
        <link rel='stylesheet' href='".$css_dir."/".$page_name."_mobile.css'>";


    }

    public static function remove_style($style){
        return str_replace('<style>', '', str_replace('</style>', '',htmlspecialchars_decode($style)));
    }


    public static function add_tablet_media(){
        return 
        '@media (min-width: calc(494px)) and (max-width: calc(900px)) {
			body {
				--coef-w: calc(var(--width) / -1310 + 1.3771);
				--offset: calc(4.6875vw * (('.strval(self::$width_mobile).' - '.strval(self::$width_mobile).' * var(--coef-w) + 30 * var(--coef-w)) / 30));
                --column-width: calc( (1px * var(--width)) - (2 * var(--offset)) );
			}
		}

		@media (max-width: calc(494px)) {
			body {
				--coef-w: 1;
				--column-width: 87.2vw;
				--offset: calc(50% - (var(--column-width) / 2));
			}
		}
        ';


    } 
}
