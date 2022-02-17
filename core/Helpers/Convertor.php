<?php

namespace App\FastAdminPanel\Helpers;

use App\FastAdminPanel\Helpers\Platform;
use Illuminate\Http\Response as Response;
use Route;

class Convertor
{

    private static $width_mobile = 320;
    private static $width_desktop = 1440;
    private static $style_source_path_desktop = 'css/desktop-src.css';
    private static $style_source_path_mobile = 'css/mobile-src.css';
    
    public static $views = [];

    public static function create ($view, $style, $is_desktop = false) {

        $style = self::remove_style($style);
                
        if ($is_desktop) {

            self::$views['desktop'][$view] = $style;
        } else {
            self::$views['mobile'][$view] = $style;
        }
    }

    public static function convert() {
        
        $cache_dir = public_path()."/css/cache";
        $css_dir = "/css/cache";
        
        $components_dir = resource_path().'/views/';
        
        if (!empty(request()->route()->getAction()['controller']))
            
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


        $page_css = $cache_dir.'/'.$page_name.'.css';

        $is_cache = true;

        if (file_exists($page_css)){

            $time_source = filemtime($page_css);
            foreach (self::$views['desktop'] as $key => $view){

                $key = str_replace('.', '/', $key);

                $time_component = filemtime($components_dir.$key.'.blade.php');
                
                $time_css_desktop = filemtime(self::$style_source_path_desktop);
                $time_css_mobile = filemtime(self::$style_source_path_mobile);

                if ($time_component > $time_source || $time_css_desktop > $time_source || $time_css_mobile > $time_source){

                    $is_cache = false;
                }
            }
        } else {

            $is_cache = false;
        }

        if ($is_cache){

    	    return "<link rel='stylesheet' href='".$css_dir."/".$page_name.".css'>";
        }

        $styles_desktop = file_get_contents(self::$style_source_path_desktop);
        
        foreach (self::$views['desktop'] as $view){

            $styles_desktop .= ' '.$view;
        }
        
        $styles_mobile = file_get_contents(self::$style_source_path_mobile);
        
        foreach (self::$views['mobile'] as $view){

            $styles_mobile .= ' '.$view;
        }
        
        $styles = '@media (min-width: 1600px) { ';
        $styles .= $styles_desktop;
        $styles .= ' }';

        $styles .= '@media (max-width: 1600px) and (min-width: 1000px) { ';
        $styles .= self::px_to_vw($styles_desktop, self::$width_desktop);
        $styles .= ' }';

        $styles .= self::add_tablet_media(); 
        $styles .= '@media (max-width: 1000px) { ';
        $styles .= self::px_to_vw($styles_mobile, self::$width_mobile);
        $styles .= ' }';

        file_put_contents($page_css, $styles);

        return "<link rel='stylesheet' href='".$css_dir."/".$page_name.".css'>";
    }

    public static function remove_style($style){

        return str_replace('<style>', '', str_replace('</style>', '',htmlspecialchars_decode($style)));
    }

    public static function px_to_vw($styles, $width) {

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

        return $styles;
    }


    public static function add_tablet_media(){

        return 
        '@media (min-width: calc(494px)) and (max-width: calc(1000px)) {
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
