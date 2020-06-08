<?php

namespace App\Http\Middleware;

use Closure;

class IpMiddleware
{

    public function handle($request, Closure $next)
    {  

        if ($request->ip() != config('app.local_address')) {

            return redirect('/admin');
        }

        return $next($request);
    }

}