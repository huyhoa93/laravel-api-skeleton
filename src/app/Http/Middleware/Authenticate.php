<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @param mixed ...$guards
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (!Auth::guard('api')->check()) {
            return response()->json(['message' => __('message.unauthorized')], 401);
        }
        return $next($request);
    }
}
