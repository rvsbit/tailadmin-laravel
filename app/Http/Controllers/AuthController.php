<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    protected string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.api.base_url');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $response = Http::acceptJson()
            ->post(config('services.api.base_url') . '/login', [
                'email' => $request->email,
                'password' => $request->password,
            ]);

        if ($response->failed()) {
            return back()
                ->withErrors(['email' => $response->json('message') ?? 'Login failed.'])
                ->withInput();
        }

        session([
            'api_token' => $response->json('token'),
            'user' => $response->json('user')
        ]);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        session()->forget(['user', 'api_token']);

        return redirect()->route('signin');
    }
}
