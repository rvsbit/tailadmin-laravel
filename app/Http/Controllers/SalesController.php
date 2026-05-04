<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SalesController extends Controller
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
            ->get("{$this->apiUrl}/sales");

        if ($response->failed()) {
            return redirect()->back()
                ->withErrors('Failed to fetch sales record: ' . $response);
        }

        $sales = $response->json('data', []);

        return view('pages.sales.index', [
            'sales' => $sales,
            'title' => 'Sales'
        ]);
    }

    public function create()
    {
        $managers = $this->getManagerList();

        return view('pages.sales.create', [
            'managers' => $managers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'manager_id' => ['required', 'numeric', 'max:255'],
            'amount' => ['required', 'numeric', 'min:1'],
        ]);

        $token = session('api_token');

        $response = Http::withToken($token)
            ->post("{$this->apiUrl}/sales", $validated);

        if ($response->failed()) {
            return back()->withErrors('Failed to add sales record.')->withInput();
        }

        return redirect()->route('sales.index')->with('success', 'Sales record added successfully.');
    }

    public function edit(string $id)
    {
        $token = session('api_token');

        $response = Http::withToken($token)
            ->get("{$this->apiUrl}/sales/{$id}");

        if ($response->failed()) {
            return redirect()->route('sales.index')->withErrors('Sale record not found.');
        }

        $sales = $response->json('data');

        $managers = $this->getManagerList();

        return view('pages.sales.edit', [
            'sales' => $sales,
            'managers' => $managers,
        ]);         
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'manager_id' => ['required', 'numeric', 'max:255'],
            'amount' => ['required', 'numeric', 'min:1'],
            'sales_date' => ['required', 'date', 'before_or_equal:today'],
        ]);

        $token = session('api_token');

        $response = Http::withToken($token)
            ->put("{$this->apiUrl}/sales/{$id}", $validated);

        if ($response->failed()) {
            return back()->withErrors('Failed to update sales.')->withInput();
        }

        return redirect()->route('sales.index')->with('success', 'Sale record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $token = session('api_token');

        $response = Http::withToken($token)
            ->delete("{$this->apiUrl}/sales/{$id}");

        if ($response->failed()) {
            return back()->withErrors('Failed to delete sale record.');
        }

        return redirect()->route('sales.index')->with('success', 'Sale record deleted successfully.');
    }

    /** 
     * to show manager name in dropdown, we need to fetch manager list from api 
     */
    public function getManagerList() 
    {
        $token = session('api_token');

        $response = Http::acceptJson()
            ->withToken($token)
            ->get("{$this->apiUrl}" . '/managers');

        $managers = $response->json('data') ?? [];

        return $managers;
    }
}
