<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;

class CheckSessionToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $token = session('api_token');

        // No token — redirect to login
        if (!$token) {
            return redirect('/signin');
        }

        // Verify token is still valid and store current user data in session
        $response = Http::withToken($token)
            ->get('http://localhost:8000/api/user');

        // Token expired or invalid — clear session and redirect
        if ($response->unauthorized() || $response->failed()) {
            session()->flush();
            return redirect('/signin')->withErrors(['session' => 'Session expired. Please login again.']);
        }

        session(['user' => $response->json()]);

        return $next($request);
    }
}
