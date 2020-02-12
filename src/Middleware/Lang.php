<?php

namespace Digiants\FastAdminPanel\Middleware;

use Closure;
use App;

class Lang
{
    /*
    * Set language depends on language tag (from URL)
    */
    public function handle($request, Closure $next)
    {
        $locale = \Digiants\FastAdminPanel\Helpers\Lang::get();

        App::setLocale($locale);

        return $next($request);
    }
}
