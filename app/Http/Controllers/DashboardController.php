<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = session('user');

        return view('pages.dashboard.index', [
            'user' => $user
        ]);
    }
}
