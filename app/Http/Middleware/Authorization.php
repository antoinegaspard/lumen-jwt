<?php

namespace App\Http\Middleware;
use Closure;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Authorization
{
    public function handle($request, Closure $next, ...$roles)
    {
        try {
    
            // Access token from the request
            $token = JWTAuth::parseToken();
    
            // Try authenticating user
            $user = $token->authenticate();
        }
        catch(TokenExpiredException $e) {
            
            // The token has expired
            return $this->unauthorized('Your token has expired. Please, login again.');
        }
        catch(TokenInvalidException $e) {
            
            // The token is invalid
            return $this->unauthorized('Invalid token.');
        }
        catch(JWTException $e) {
    
            // Global error
            return $this->unauthorized('Internal server error.');
        }
    
        // If token is OK and role is acceptable
        if($user && in_array($user->role, $roles)) {
            return $next($request);
        }
    
        return $this->unauthorized();
    }
    
    private function unauthorized($message = null){
        return response()->json([
            'message' => $message ? $message : 'You are unauthorized to access this resource.',
            'success' => false,
            'code' => 401,
        ], 401);
    }
}