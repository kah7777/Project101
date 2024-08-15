<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isDoctorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if(auth('sanctum')->user()->isDoctor()) {
            return $next($request);
        }
        abort(403, "Not a doctor");
    }
}
