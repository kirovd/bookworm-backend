<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    public function handle($request, Closure $next)
    {
        // Add CORS headers
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }

    protected $middleware = [
        // Other middleware entries...
        \App\Http\Middleware\Cors::class,
    ];

    protected $middlewareGroups = [
        'web' => [
            // Other web middleware entries...
            \App\Http\Middleware\Cors::class,
        ],
        'api' => [
            // Other API middleware entries...
            \App\Http\Middleware\Cors::class,
        ],
    ];

}
