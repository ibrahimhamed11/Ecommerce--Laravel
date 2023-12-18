<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            // Check if a token is present in the request headers
            $token = $this->auth->parseToken()->authenticate();

            // If the token is valid, proceed with the request
            return $next($request);
        } catch (Exception $e) {
            // If the token is invalid or not present, return an error response
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}