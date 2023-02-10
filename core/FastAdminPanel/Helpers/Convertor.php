<?php

namespace App\FastAdminPanel\Helpers;

use App\FastAdminPanel\Helpers\Platform;
use Illuminate\Http\Response as Response;
use Route;

class Convertor
{

    private static $width = [
        'desktop'   => 1440,
        'mobile'    => 320,
    ];

    private static $style_source_path = [
        'desktop'   => 'css/desktop-src.css',
        'mobile'    => 'css/mobile-src.css',
    ];
    
    public static $views = [];

    public static function create ($view, $style, $is_desktop = false) {
                
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
        
        if (!empty(request()->route()->getAction()['controller'])) {

            $method = request()->route()->getAction()['controller'];

        } else {

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

        if (file_exists($page_css)) {

            // TODO: need collision research
            $base_time = filemtime(self::$style_source_path['desktop']);
            $cache_time = $base_time;

            $cache_time += $base_time - filemtime(self::$style_source_path['mobile']);

            foreach (self::$views['desktop'] as $key => $view){

                $key = str_replace('.', '/', $key);

                $cache_time += $base_time - filemtime($components_dir.$key.'.blade.php');
            }

            $time_source = filemtime($page_css);

            if ($time_source != $cache_time) {

                $is_cache = false;
            }

        } else {

            $is_cache = false;
        }

        if ($is_cache) {

            return "<link rel='stylesheet' href='".$css_dir."/".$page_name.".css?v=".filemtime($cache_dir.'/'.$page_name.'.css')."'>";
        }

        $style_files = [];

        foreach (['desktop', 'mobile'] as $device) {
            
            $style_files[$device] = file_get_contents(self::$style_source_path[$device]);

            foreach (self::$views[$device] as $view) {

                $style_files[$device] .= ' ' . self::remove_tags($view);
            }
        }
        
        $styles = '@media (min-width: 1600px) { ';
        $styles .= $style_files['desktop'];
        $styles .= ' }';

        $styles .= '@media (max-width: 1600px) and (min-width: 1000px) { ';
        $styles .= self::px_to_vw($style_files['desktop'], self::$width['desktop']);
        $styles .= ' }';

        $styles .= self::add_tablet_media(); 
        $styles .= '@media (max-width: 1000px) { ';
        $styles .= self::px_to_vw($style_files['mobile'], self::$width['mobile']);
        $styles .= ' }';

        file_put_contents($page_css, $styles);
        touch($page_css, $cache_time ?? null);

        return "<link rel='stylesheet' href='".$css_dir."/".$page_name.".css?v=".filemtime($cache_dir.'/'.$page_name.'.css')."'>";
    }

    public static function remove_tags($style) {

        return str_replace(['</style>', '<style>'], ['',''], htmlspecialchars_decode($style));
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


    public static function add_tablet_media() {

        return 
        '@media (min-width: calc(494px)) and (max-width: calc(1000px)) {
            body {
                --coef-w: calc(var(--width) / -1310 + 1.3771);
                --offset: calc(4.6875vw * (('.strval(self::$width['mobile']).' - '.strval(self::$width['mobile']).' * var(--coef-w) + 30 * var(--coef-w)) / 30));
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