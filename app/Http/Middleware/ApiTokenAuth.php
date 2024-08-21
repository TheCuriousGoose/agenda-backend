<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApiTokenAuth
{
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');

        if ($token) {
            // Extract the token from 'Bearer <token>'
            $token = str_replace('Bearer ', '', $token);

            // Find the user with the given token
            $user = User::where('api_token', $token)->first();

            if ($user) {
                // Authenticate the user
                Auth::login($user);
                return $next($request);
            }
        }

        // If no valid token, respond with unauthorized
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
