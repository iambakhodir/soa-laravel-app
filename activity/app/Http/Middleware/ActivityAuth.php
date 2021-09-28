<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class ActivityAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (config('servicies.activity_service.secret_token')->contains($request->bearerToken())) {
            return $next($request);
        }

        return response([
            'message' => 'Unauthenticated'
        ], 403);
    }
}