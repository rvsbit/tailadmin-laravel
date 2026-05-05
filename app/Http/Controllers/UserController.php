<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
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
            ->get("{$this->apiUrl}/user");

        if ($response->failed()) {
            return redirect()->back()
                ->withErrors('Failed to fetch users record: ' . $response);
        }

        $users = $response->json('data', []);

        return view('pages.users.index', [
            'users' => $users,
            'title' => 'Roles'
        ]);
    }

    public function create()
    {
        $roles = $this->getRoleList();

        return view('pages.users.create', [
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['required', 'string', 'max:20'],
            'username_tiktok' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'in:1,2'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $token = session('api_token');

        $response = Http::withToken($token)
            ->post("{$this->apiUrl}/user", $validated);

        if ($response->failed()) {
            return back()->withErrors('Failed to add users record.')->withInput();
        }

        return redirect()->route('users.index')->with('success', 'User record added successfully.');
    }

    /**
     * Update the specified resource.
     */
    public function edit(string $id)
    {
        $token = session('api_token');

        $response = Http::withToken($token)
            ->get("{$this->apiUrl}/user/{$id}");

        if ($response->failed()) {
            return redirect()->route('users.index')->withErrors('User record not found.');
        }

        $users = $response->json('data');

        $roles = $this->getRoleList();

        return view('pages.users.edit', [
            'users' => $users,
            'roles' => $roles,
        ]);         
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $fields = [
            'name', 
            'email', 
            'password',
            'phone', 
            'username_tiktok', 
            'status', 
            'role_id', 
            'level'
        ];

        $data = array_filter(
            $request->only($fields),
            fn($value) => !is_null($value)
        );

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $token = session('api_token');

        $response = Http::withToken($token)
            ->put("{$this->apiUrl}/user/{$id}", $data);

        if ($response->failed()) {
            return back()->withErrors('Failed to update users.')->withInput();
        }

        return redirect()->route('users.index')->with('success', 'User record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $token = session('api_token');

        $response = Http::withToken($token)
            ->delete("{$this->apiUrl}/user/{$id}");

        if ($response->failed()) {
            return back()->withErrors('Failed to delete user record.');
        }

        return redirect()->route('users.index')->with('success', 'User record deleted successfully.');
    }

    /** 
     * to show roles list in dropdown, we need to fetch the list from api 
     */
    public function getRoleList() 
    {
        $token = session('api_token');

        $response = Http::acceptJson()
            ->withToken($token)
            ->get("{$this->apiUrl}" . '/roles');

        $roles = $response->json('data') ?? [];

        return $roles;
    }

}
