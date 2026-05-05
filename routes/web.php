<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommisionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\UserController;

// authentication routes
// Route::get('/', fn() => redirect()->route('signin'));
Route::middleware('guest.session')->group(function () {
    Route::get('/signin', fn() => view('pages.auth.signin'))->name('signin');
    Route::post('/signin', [AuthController::class, 'login'])->name('signin.post');
    Route::get('/signup', fn() => view('pages.auth.signup'))->name('signup');
});

Route::middleware('web')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // commision management
    Route::resource('commision', CommisionController::class);

    // role management
    Route::resource('roles', RoleController::class);

    // sales management
    Route::resource('sales', SalesController::class);
    Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');

    // users management
    Route::resource('users', UserController::class);
});




// authentication pages
Route::get('/signin', function () {
    return view('pages.auth.signin', ['title' => 'Sign In']);
})->name('signin');

// Route::post('/signin', [AuthController::class, 'login'])->name('signin.post');

Route::get('/signup', function () {
    return view('pages.auth.signup', ['title' => 'Sign Up']);
})->name('signup');






















