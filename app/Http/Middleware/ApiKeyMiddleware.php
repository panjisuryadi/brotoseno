<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class ApiKeyMiddleware
{
 
public function handle($request, Closure $next)
    {
        $response = $next($request);
        $error = response([
                    'status' => 'error',
                    'data' => "unauthorized"
                ], 403);

        $apiKey = config('app.api_key');

        $apiKeyIsValid = (
            ! empty($apiKey)
            && $request->get('api_key') == $apiKey
        );
         
        abort_if (! $apiKeyIsValid, $error);

        return $response;
    }





}
