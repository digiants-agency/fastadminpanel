<?php

namespace Digiants\FastAdminPanel\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectSEO
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (!env('APP_DEBUG')) {

            $domain = parse_url(env('APP_URL'), PHP_URL_HOST);
            $url = url()->full();

            $filtered_url = preg_replace('/\/+/', '/', $url);
            if (strpos($filtered_url, '%') === false) {
                $filtered_url = mb_strtolower($filtered_url);
            }
            $filtered_url = str_replace($domain.'/index.php', $domain, $filtered_url);
            $filtered_url = str_replace('http:/', 'https:/', $filtered_url);
            $filtered_url = str_replace('https:/', 'https://', $filtered_url);
            $filtered_url = str_replace('https://www.', 'https://', $filtered_url);

            if ($filtered_url != $url) {

                return redirect($filtered_url, 301);
            }
        }

        return $next($request);
    }
}
