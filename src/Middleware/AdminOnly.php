<?php

namespace Digiants\FastAdminPanel\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminOnly {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $user = Auth::user();

        if ($user == null || $user->id_roles != 1) {
            return redirect('/login');
        }

        return $next($request);
    }
}