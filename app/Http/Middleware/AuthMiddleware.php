<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $authHeader = $request->header('Authorization');
        $condition = true;
        if (!empty($authHeader)) {
            $authCode = explode(' ', $authHeader);
            if ($authCode[0] == 'Bearer') {
                $key = env('JWT_SECRET', false);
                try {
                    $decoded = JWT::decode($authCode[1], $key, ['HS256']);
                    Auth::loginUsingId($decoded->id);
                } catch (\Exception $e) {
                    $condition = false;
                }
                
            } else {
                $condition = false;
            }
        } else {
            $condition = false;
        }
        
        if ($condition) {
            return $next($request);
        } else {
            return response(['message' => 'Не авторизован'], 401);
        }
    }
}
