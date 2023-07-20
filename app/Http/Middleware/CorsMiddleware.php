<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $responses = $next($request);
        $responses->header('Access-Control-Allow-Origin', env('CORS_ALLOWED_ORIGINS', '*'));
        $responses->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $responses->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        return $responses;
    }
}
