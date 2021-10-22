<?php

namespace App\FastAdminPanel\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectSEO
{
    public function handle($request, Closure $next, $guard = null)
    {
        $domain = parse_url(env('APP_URL'), PHP_URL_HOST);
        
        if (!isset($_SERVER['HTTP_HOST']))
            return $next($request);

        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $filtered_url = preg_replace('/\/+/', '/', $url);
        
        if (mb_strpos($filtered_url, '%') === false)
            $filtered_url = mb_strtolower($filtered_url);
        
        if ($_SERVER['REQUEST_URI'] != '/')
            $filtered_url = rtrim($filtered_url, '/');
        
        $filtered_url = str_replace(
            [
                $domain.'/index.php',
                'http:/',
                'https:/',
                'https://www.',
            ], 
            [
                $domain,
                'https:/',
                'https://',
                'https://'
            ], 
            $filtered_url
        );

        if ($filtered_url != $url) {
            return redirect($filtered_url, 301);
        }

        return $next($request);
    }
}
