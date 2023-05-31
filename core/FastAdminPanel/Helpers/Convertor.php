<?php

namespace App\FastAdminPanel\Helpers;

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

    public static function create ($view, $style, $isDesktop = false)
    {            
        if ($isDesktop) {
            self::$views['desktop'][$view] = $style;
        } else {
            self::$views['mobile'][$view] = $style;
        }
    }

    public static function convert()
    {
        // TODO: need collision research
        $hash = hash('md5', implode('', array_keys(self::$views['desktop'] ?? [])));

        $cacheDir = public_path()."/css/cache";
        $cssDir = "/css/cache";
        
        $componentsDir = resource_path().'/views/';

        if (!empty(request()->attributes->get('controllerName'))) {
            
            $method = request()->attributes->get('controllerName');

        } elseif (!empty(request()->route()->getAction()['controller'])) {

            $method = request()->route()->getAction()['controller'];

        } else {

            $method = '404';
        }

        $pageName = strtolower(
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

        $pageCss = $cacheDir.'/'.$pageName.$hash.'.css';

        $isCache = true;

        $cacheTime = filemtime(self::$style_source_path['desktop']);

        if (file_exists($pageCss)) {

            $base_time = filemtime(self::$style_source_path['desktop']);
            $cacheTime = $base_time;

            $cacheTime += $base_time - filemtime(self::$style_source_path['mobile']);

            if (isset(self::$views['desktop'])) {

                foreach (self::$views['desktop'] as $key => $view){

                    $key = str_replace('.', '/', $key);
    
                    $cacheTime += $base_time - filemtime($componentsDir.$key.'.blade.php');
                }
            }

            $time_source = filemtime($pageCss);

            if ($time_source != $cacheTime) {

                $isCache = false;
            }

        } else {

            $isCache = false;
        }

        if ($isCache) {

            return "<link rel='stylesheet' href='".$cssDir."/".$pageName.$hash.".css?v=".filemtime($cacheDir.'/'.$pageName.$hash.'.css')."'>";
        }

        $styleFiles = [];

        foreach (['desktop', 'mobile'] as $device) {
            
            $styleFiles[$device] = file_get_contents(self::$style_source_path[$device]);

            if (isset(self::$views[$device])) {

                foreach (self::$views[$device] as $view) {

                    $styleFiles[$device] .= ' ' . self::removeTags($view);
                }
            }
        }
        
        $styles = '@media (min-width: 1600px) { ';
        $styles .= $styleFiles['desktop'];
        $styles .= ' }';

        $styles .= '@media (max-width: 1600px) and (min-width: 1000px) { ';
        $styles .= self::pxToVw($styleFiles['desktop'], self::$width['desktop'], 'desktop');
        $styles .= ' }';

        $styles .= self::addTabletMedia(); 
        $styles .= '@media (max-width: 1000px) { ';
        $styles .= self::pxToVw($styleFiles['mobile'], self::$width['mobile'], 'mobile');
        $styles .= ' }';

        file_put_contents($pageCss, $styles);
        touch($pageCss, $cacheTime);

        return "<link rel='stylesheet' href='".$cssDir."/".$pageName.$hash.".css?v=".filemtime($cacheDir.'/'.$pageName.$hash.'.css')."'>";
    }

    public static function removeTags($style)
    {
        return str_replace(['</style>', '<style>'], ['',''], htmlspecialchars_decode($style));
    }

    public static function pxToVw($styles, $width, $platform)
    {
        preg_match_all('/[ :]{1}[-]{0,1}[0-9\.]+px/', $styles, $matches);

        for ($i = 0; $i < count($matches[0]); $i++) {

            if ($matches[0][$i] == ' 1px' || 
                $matches[0][$i] == ' 2px' || 
                $matches[0][$i] == ' 3px' || 
                $matches[0][$i] == ' -1px' || 
                $matches[0][$i] == ' -2px' || 
                $matches[0][$i] == ' -3px'){
                    
                    continue;
            }

            $val = floatval($matches[0][$i]);

            $vw = round($val / $width * 100, 4);

            if ($platform == 'mobile'){

                $styles = str_replace($matches[0][$i], ' calc('.$vw.'vw * var(--coef-w))', $styles);
            
            } else {

                $styles = str_replace($matches[0][$i], ' '.$vw.'vw', $styles);
            } 
            
        }

        return $styles;
    }


    public static function addTabletMedia()
    {
        return 
        '@media (min-width: calc(494px)) and (max-width: calc(1000px)) {
            body {
                --coef-w: calc(var(--width) / -910 + 1.3771);
                --offset: calc(4.6875vw * (('.strval(self::$width['mobile']).' - '.strval(self::$width['mobile']).' * var(--coef-w) + 30 * var(--coef-w)) / 30));
                --column-width: calc( (1px * var(--width)) - (2 * var(--offset)) );
            }
        }

        @media (max-width: calc(494px)) {
            body {
                --coef-w: 1;
                --column-width: 90.625vw;
                --offset: calc(50% - (var(--column-width) / 2));
            }
        }
        ';
    } 
}