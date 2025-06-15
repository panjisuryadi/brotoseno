<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class csrf419
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
        {
            $response = $next($request);

            if ($response->status() === 419) {
                auth()->logout();
                return redirect('/')->with('status', 'Your session has expired. Please login again.');
            }

            return $response;
        }

}
