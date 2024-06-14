<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    const ACCESS_FORBIDDEN_HTTP_STATUS = 403;
    public function handle(Request $request, Closure $next)
    {
        if (auth('api')->check()) {
            return $next($request);
        }

        return response()->json(
            array (
                'status' => FALSE,
                'message' => 'Akses tidak sah'
            ),
            self::ACCESS_FORBIDDEN_HTTP_STATUS
        );
    }
}