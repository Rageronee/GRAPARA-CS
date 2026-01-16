<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CS Routes
    Route::post('/cs/next', [QueueController::class, 'next'])->name('cs.next');
    Route::post('/queue/call/{queue}', [QueueController::class, 'callSpecific'])->name('queue.call_specific');
    Route::post('/cs/complete/{queue}', [QueueController::class, 'complete'])->name('cs.complete');
    Route::get('/cs', [DashboardController::class, 'index']); // Alias

    // User History
    Route::get('/queue/history', [QueueController::class, 'history'])->name('queue.history');
});

// Public Queue Routes
Route::post('/queue/ticket', [QueueController::class, 'store'])->name('queue.store');
Route::get('/queue/{queue}', [QueueController::class, 'show'])->name('queue.show');
