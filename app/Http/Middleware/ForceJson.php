<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class ForceJson
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
        // Force Json accept type
        $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}
