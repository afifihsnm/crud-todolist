<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Exceptions\HttpResponseException;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('API-KEY');

        if (!$token) throw new HttpResponseException(response()->json([
            'message' => 'Token Tidak Di Temukan',
            'errors' => []
        ], 401));

        try {
            $result = JWT::decode($token, new Key(env('JWT_SECRET_KEY'), 'HS256'));
        } catch (\Exception $e) {
            throw new HttpResponseException(response()->json([
                'message' => 'Token Invalid',
                "errors" => []
            ], 401));
        }
        
        return $next($request);
    }
}
