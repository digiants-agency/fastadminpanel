<?php

namespace App\FastAdminPanel\Middleware;

use Closure;
use App;

class Lang
{
    /*
    * Set language depends on language tag (from URL)
    */
    public function handle($request, Closure $next)
    {
        $locale = \App\FastAdminPanel\Helpers\Lang::get();

        App::setLocale($locale);

        return $next($request);
    }
}
