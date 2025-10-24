<?php

namespace App\FastAdminPanel\Helpers;

use Illuminate\Http\Request;

// TODO: make service + facade singleton
class Convertor
{
    private static $width = [
        'desktop' => 1440,
        'mobile' => 320,
    ];

    private static $styleSourcePath = [
        'desktop' => [
            'css/desktop-src.css',
            // 'css/desktop-forms-src.css', // just for example
        ],
        'mobile' => [
            'css/mobile-src.css',
            // 'css/mobile-forms-src.css', // just for example
        ],
    ];

    public static $views = [];

    public static function create($view, $style, $isDesktop = false)
    {
        if ($isDesktop) {
            self::$views['desktop'][$view] = $style;
        } else {
            self::$views['mobile'][$view] = $style;
        }
    }

    public static function convert()
    {
        $request = app(Request::class);

        // TODO: need collision research
        $hash = hash('md5', implode('', array_keys(self::$views['desktop'] ?? [])));

        $cachePath = public_path('css/cache');
        $cacheUrl = '/css/cache';

        $componentsDir = resource_path('views/');

        if (! empty($request->attributes->get('controllerName'))) {

            $method = $request->attributes->get('controllerName');

        } elseif (! empty($request->route()->getAction()['controller'])) {

            $method = $request->route()->getAction()['controller'];

        } else {

            $method = '404';
        }

        $pageName = strtolower(
            str_replace(
                [
                    'App\Http\Controllers\\',
                    '@',
                    'Controller',
                ],
                [
                    '',
                    '_',
                    '',
                ],
                $method
            )
        );

        $filePathL = $cachePath.'/l'.$pageName.$hash.'.css';

        $isCache = true;

        $cacheTime = filemtime(self::$styleSourcePath['desktop'][0]);

        if (file_exists($filePathL)) {

            $baseTime = filemtime(self::$styleSourcePath['desktop'][0]);
            $cacheTime = $baseTime;

            foreach (self::$styleSourcePath['desktop'] as $path) {
                $cacheTime += $baseTime - filemtime($path);
            }

            foreach (self::$styleSourcePath['mobile'] as $path) {
                $cacheTime += $baseTime - filemtime($path);
            }

            if (isset(self::$views['desktop'])) {

                foreach (self::$views['desktop'] as $key => $view) {

                    $key = str_replace('.', '/', $key);

                    $cacheTime += $baseTime - filemtime($componentsDir.$key.'.blade.php');
                }
            }

            $timeSource = filemtime($filePathL);

            if ($timeSource != $cacheTime) {

                $isCache = false;
            }

        } else {

            $isCache = false;
        }

        if ($isCache) {

            $version = filemtime($cachePath.'/l'.$pageName.$hash.'.css');

            $links = '<link rel="stylesheet" href="'.$cacheUrl.'/l'.$pageName.$hash.'.css?v='.$version.'" media="screen and (min-width: 1600px)">';
            $links .= '<link rel="stylesheet" href="'.$cacheUrl.'/m'.$pageName.$hash.'.css?v='.$version.'" media="screen and (max-width: 1599px) and (min-width: 1001px)">';
            $links .= '<link rel="stylesheet" href="'.$cacheUrl.'/s'.$pageName.$hash.'.css?v='.$version.'" media="screen and (max-width: 1000px)">';

            return $links;
        }

        $styleFiles = [
            'desktop' => '',
            'mobile' => '',
        ];

        foreach (['desktop', 'mobile'] as $device) {

            foreach (self::$styleSourcePath[$device] as $path) {

                $styleFiles[$device] .= file_get_contents($path);
            }

            if (isset(self::$views[$device])) {

                foreach (self::$views[$device] as $view) {

                    $styleFiles[$device] .= ' '.self::removeTags($view);
                }
            }
        }

        $filePathM = $cachePath.'/m'.$pageName.$hash.'.css';
        $filePathS = $cachePath.'/s'.$pageName.$hash.'.css';

        $tabletStyles = '
            @media (min-width: calc(494px)) and (max-width: calc(1000px)) {
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
            }';
        $mobileStyles = self::pxToVw($styleFiles['mobile'], self::$width['mobile'], 'mobile');

        self::saveToFile($filePathL, $styleFiles['desktop'], $cacheTime);
        self::saveToFile($filePathM, self::pxToVw($styleFiles['desktop'], self::$width['desktop'], 'desktop'), $cacheTime);
        self::saveToFile($filePathS, $tabletStyles.$mobileStyles, $cacheTime);

        $version = filemtime($cachePath.'/l'.$pageName.$hash.'.css');

        $links = '<link rel="stylesheet" href="'.$cacheUrl.'/l'.$pageName.$hash.'.css?v='.$version.'" media="screen and (min-width: 1600px)">';
        $links .= '<link rel="stylesheet" href="'.$cacheUrl.'/m'.$pageName.$hash.'.css?v='.$version.'" media="screen and (max-width: 1599px) and (min-width: 1001px)">';
        $links .= '<link rel="stylesheet" href="'.$cacheUrl.'/s'.$pageName.$hash.'.css?v='.$version.'" media="screen and (max-width: 1000px)">';

        return $links;
    }

    protected static function saveToFile($filePath, $styles, $cacheTime)
    {
        file_put_contents($filePath, $styles);
        touch($filePath, $cacheTime);
    }

    protected static function removeTags($style)
    {
        return str_replace(['</style>', '<style>'], ['', ''], htmlspecialchars_decode($style));
    }

    protected static function pxToVw($styles, $width, $platform)
    {
        preg_match_all('/[ :]{1}[-]{0,1}[0-9\.]+px/', $styles, $matches);

        for ($i = 0; $i < count($matches[0]); $i++) {

            if ($matches[0][$i] == ' 1px' ||
                $matches[0][$i] == ' 2px' ||
                $matches[0][$i] == ' 3px' ||
                $matches[0][$i] == ' -1px' ||
                $matches[0][$i] == ' -2px' ||
                $matches[0][$i] == ' -3px') {

                continue;
            }

            $val = floatval($matches[0][$i]);

            $vw = round($val / $width * 100, 4);

            if ($platform == 'mobile') {

                $styles = str_replace($matches[0][$i], ' calc('.$vw.'vw * var(--coef-w))', $styles);

            } else {

                $styles = str_replace($matches[0][$i], ' '.$vw.'vw', $styles);
            }

        }

        return $styles;
    }
}
