<?php

namespace MicroweberPackages\App\Http\Middleware;

use Closure;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     public function handle($request, Closure $next)
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Security-Policy: frame-ancestors *");
        header('X-XSS-Protection: 0');
        header('X-Frame-Options: *');
        header('Set-Cookie: SameSite=None; Secure');
        $headers = [
            'Access-Control-Allow-Methods' => 'POST,GET,OPTIONS,PUT,DELETE',
            'Access-Control-Allow-Headers' => '*',
            // 'Access-Control-Allow-Headers' => 'Content-Type, X-Auth-Token, Origin, Authorization',
        ];
        if ($request->getMethod() == "OPTIONS") {
            return response()->json('OK', 200, $headers);
        }
        $response = $next($request);
        foreach ($headers as $key => $value) {
            if (method_exists($response, 'header')) {
                $response->header($key, $value);
            }
        }
        return $response;
    }
}