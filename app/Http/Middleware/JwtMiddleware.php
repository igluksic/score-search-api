<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use App\JsonApi\MicroJsonApi;

class JwtMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (config('app.useAuth') == 0) return $next($request);

        $token = $request->get('token');

        $jsonApiStatus = (new MicroJsonApi())->checkHeaders($request);
        if ($jsonApiStatus == 200) {
            $headers = ['Content-Type' => 'application/vnd.api+json'];
        } else {
            $headers = [];
        }

        if(!$token) {
            // Unauthorized response if token isn't provided

            return response()->json([
                'error' => 'Token not provided.'
            ], 401, $headers);
        }
        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch(ExpiredException $e) {
            return response()->json([
                'error' => 'Provided token is expired.'
            ], 400, $headers);
        } catch(Exception $e) {
            return response()->json([
                'error' => 'An error while decoding token.'
            ], 400, $headers);
        }
        $user = User::find($credentials->sub);
        $request->auth = $user;
        return $next($request);
    }
}
