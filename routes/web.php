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

Route::get('/debug-test', function () {
    try {
        // 1. Check File Write Permission (Should fail on Vercel unless /tmp)
        $path = storage_path('framework/testing_write.txt');
        try {
            file_put_contents($path, 'test');
            $writeStatus = "Writable (Warning: Storage is writable? Should be Read-Only on Vercel)";
            unlink($path);
        } catch (\Exception $e) {
            $writeStatus = "Read-Only (Expected on Vercel): " . $e->getMessage();
        }

        // 2. Check Session
        session(['test_key' => 'Hello Vercel']);
        $sessionStatus = session('test_key') === 'Hello Vercel' ? "Working" : "Failed";

        // 3. Check Database
        \DB::connection()->getPdo();
        $dbStatus = "Connected to " . \DB::connection()->getDatabaseName();

        // 4. Check View Cache Path
        $viewPath = config('view.compiled');

        return response()->json([
            'environment' => app()->environment(),
            'storage_path_write' => $writeStatus,
            'session_driver' => config('session.driver'),
            'session_status' => $sessionStatus,
            'database_status' => $dbStatus,
            'ssl_cert_path' => env('MYSQL_ATTR_SSL_CA'),
            'view_compiled_path' => $viewPath,
            'php_version' => phpversion(),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'CRITICAL ERROR',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});
