<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsGuardianMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if(auth('sanctum')->user()->isGuardian()) {
            return $next($request);
        }
        abort(403, "Not a guardian");
    }
}
