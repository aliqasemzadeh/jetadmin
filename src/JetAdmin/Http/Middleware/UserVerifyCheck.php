<?php

namespace AliQasemzadeh\JetAdmin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserVerifyCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
