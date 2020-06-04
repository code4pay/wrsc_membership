<?php

namespace App\Http\Middleware;

use Closure;

class IpMiddleware
{

    public function handle($request, Closure $next)
    {
        if ($request->ip() != "127.0.0.1") {
            return redirect('/admin');
        }

        return $next($request);
    }

}