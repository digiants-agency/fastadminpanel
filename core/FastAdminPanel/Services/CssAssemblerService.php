<?php

namespace App\FastAdminPanel\Services;

class CssAssemblerService
{
    public $views = [];

    private $styleSourcePath = 'css/style.css';

    public function create($view, $style)
    {            
        $this->views[$view] = $style;
    }

    public function convert()
    {
        // TODO: need collision research
        $hash = hash('md5', implode('', array_keys($this->views ?? [])));

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

        $cacheTime = filemtime($this->styleSourcePath);

        if (file_exists($pageCss)) {

            $baseTime = filemtime($this->styleSourcePath);
            $cacheTime = $baseTime;

            foreach ($this->views as $key => $view){

                $key = str_replace('.', '/', $key);

                $cacheTime += abs($baseTime - filemtime($componentsDir.$key.'.blade.php'));
            }

            $timeSource = filemtime($pageCss);

            if ($timeSource != $cacheTime) {

                $isCache = false;
            }

        } else {

            $isCache = false;
        }

        if ($isCache) {

            return "<link rel='stylesheet' href='".$cssDir."/".$pageName.$hash.".css?v=".filemtime($cacheDir.'/'.$pageName.$hash.'.css')."'>";
        }

        $styleFile = file_get_contents($this->styleSourcePath);

        foreach ($this->views as $view) {

            $styleFile .= ' ' . self::removeTags($view);
        }
        
        file_put_contents($pageCss, $styleFile);
        touch($pageCss, $cacheTime);

        return "<link rel='stylesheet' href='".$cssDir."/".$pageName.$hash.".css?v=".filemtime($cacheDir.'/'.$pageName.$hash.'.css')."'>";
    }

    public function removeTags($style)
    {
        return str_replace(['</style>', '<style>'], ['',''], htmlspecialchars_decode($style));
    }
}