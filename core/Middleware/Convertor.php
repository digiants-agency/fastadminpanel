<?php

namespace App\FastAdminPanel\Middleware;

class Convertor
{
    public function handle($request, $next, $guard = null)
    {	
        $response = $next($request);
        
        if ($response->status() !== 500) {

            $response->setContent(
                str_replace('%convertor%', \App\FastAdminPanel\Helpers\Convertor::convert(), $response->content())
            );        
        }
        
        return $response;
    }
}