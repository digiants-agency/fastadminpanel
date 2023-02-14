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

        $filteredUrl = preg_replace('/\/+/', '/', $url);
        
        if (mb_strpos($filteredUrl, '%') === false)
            $filteredUrl = mb_strtolower($filteredUrl);
        
        if ($_SERVER['REQUEST_URI'] != '/')
            $filteredUrl = rtrim($filteredUrl, '/');
        
        $filteredUrl = str_replace(
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
            $filteredUrl
        );

        if ($filteredUrl != $url) {
            return redirect($filteredUrl, 301);
        }

        return $next($request);
    }
}
