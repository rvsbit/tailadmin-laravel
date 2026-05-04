<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CommisionController extends Controller
{

    protected string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.api.base_url');
    }

    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        $token = session('api_token');
        
        $response = Http::withToken($token)
            ->get("{$this->apiUrl}/rates");

        if ($response->failed()) {
            return redirect()->route('dashboard')->withErrors('Failed to fetch rate.');
        }

        $rate = $response->json('data', []);

        return view('pages.commision.index', ['rates' => $rate, 'title' => 'Commision Rate']);
    }

    public function create()
    {
        return view('pages.commision.create', ['title' => 'Create Commision']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'level' => ['required', 'string', 'max:255'],
            'rate' => ['required', 'numeric', 'min:0'],
        ]);

        $token = session('api_token');

        $response = Http::withToken($token)
            ->post("{$this->apiUrl}/rates", $validated);

        if ($response->failed()) {
            return back()->withErrors('Failed to add commision rate.')->withInput();
        }

        return redirect()->route('commision.index')->with('success', 'Commision rate created successfully.');
    }

    public function edit(string $id)
    {
        $token = session('api_token');

        $response = Http::withToken($token)
            ->get("{$this->apiUrl}/rates/{$id}");

        if ($response->failed()) {
            return back()->withErrors('Failed to add commision rate.')->withInput();
        }

        $rates = $response->json('data');

        return view('pages.commision.edit', ['rates' => $rates, 'title' => 'Edit Commision Rate']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'level' => ['required', 'string', 'max:255'],
            'rate' => ['required', 'numeric', 'min:0'],
        ]);

        $token = session('api_token');

        $response = Http::withToken($token)
            ->put("{$this->apiUrl}/rates/{$id}", $validated);

        if ($response->failed()) {
            return back()->withErrors('Failed to update commision rate.')->withInput();
        }

        return redirect()->route('commision.index')->with('success', 'Commision rate updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $token = session('api_token');

        $response = Http::withToken($token)
            ->delete("{$this->apiUrl}/rates/{$id}");

        if ($response->failed()) {
            return back()->withErrors('Failed to delete commision rate.');
        }

        return redirect()->route('commision.index')->with('success', 'Commision deleted successfully.');
    }
}
