<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StaticApiTokenAuthentication
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
        $providedToken = $request->header('token');

        $validToken = env('STATIC_API_TOKEN'); // Ganti dengan token kustom Anda

        if ($providedToken !== $validToken) {
            return response()->json(['message' => 'Access denied'], 401);
        }

        return $next($request);
    }
}
