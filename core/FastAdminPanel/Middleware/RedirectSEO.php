<?php

namespace App\FastAdminPanel\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectSEO
{
    public function handle($request, Closure $next, $guard = null)
    {
        $domain = $_SERVER['SERVER_NAME'] ?? parse_url(config('app.url'), PHP_URL_HOST);
        
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$domain$_SERVER[REQUEST_URI]";

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
