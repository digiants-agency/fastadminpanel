<?php

namespace App\FastAdminPanel\Middleware;

class CssAssembler
{
    public function handle($request, $next, $guard = null)
    {	
        $response = $next($request);
        
        if ($response->status() !== 500) {

            $response->setContent(
                str_replace('%css%', \App\FastAdminPanel\Facades\CssAssembler::convert(), $response->content())
            );        
        }
        
        return $response;
    }
}