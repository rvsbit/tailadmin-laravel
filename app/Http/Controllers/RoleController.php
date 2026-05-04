<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RoleController extends Controller
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
            ->get("{$this->apiUrl}/roles");

        if ($response->failed()) {
            return redirect()->route('dashboard')->withErrors('Failed to fetch roles.');
        }

        $roles = $response->json('data', []);

        return view('pages.roles.index', ['roles' => $roles, 'title' => 'Roles']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.roles.create', ['title' => 'Create Role']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $token = session('api_token');

        $response = Http::withToken($token)
            ->post("{$this->apiUrl}/roles", $validated);

        if ($response->failed()) {
            return back()->withErrors('Failed to create role.')->withInput();
        }

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $token = session('api_token');

        $response = Http::withToken($token)
            ->get("{$this->apiUrl}/roles/{$id}");

        if ($response->failed()) {
            return redirect()->route('roles.index')->withErrors('Role not found.');
        }

        $role = $response->json('data');

        return view('pages.roles.edit', ['role' => $role, 'title' => 'Edit Role']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $token = session('api_token');

        $response = Http::withToken($token)
            ->put("{$this->apiUrl}/roles/{$id}", $validated);

        if ($response->failed()) {
            return back()->withErrors('Failed to update role.')->withInput();
        }

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $token = session('api_token');

        $response = Http::withToken($token)
            ->delete("{$this->apiUrl}/roles/{$id}");

        if ($response->failed()) {
            return back()->withErrors('Failed to delete role.');
        }

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
