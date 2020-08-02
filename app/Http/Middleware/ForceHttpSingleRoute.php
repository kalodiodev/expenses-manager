<?php

namespace App\Http\Middleware;

use Closure;

class ForceHttpSingleRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! auth()->user()) {
            return $next($request);
        }

        if ($request->is('/') || $request->is('logout') || $request->isJson() || $request->ajax()) {
            return $next($request);
        }

        return redirect('/');
    }
}
