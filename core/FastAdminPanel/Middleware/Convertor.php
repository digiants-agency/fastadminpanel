<?php

namespace App\FastAdminPanel\Middleware;

class Convertor
{
    // TODO: change replace logic to view composer or blade directive
    public function handle($request, $next, $guard = null)
    {
        $response = $next($request);

        if ($response->status() !== 500) {

            $content = $response->content();
            $strpos = strpos($content, '%convertor%');

            if ($strpos === false) {
                return $response;
            }

            $response->setContent(
                substr_replace(
                    $content,
                    \App\FastAdminPanel\Helpers\Convertor::convert(),
                    $strpos,
                    12
                )
            );
        }

        return $response;
    }
}
