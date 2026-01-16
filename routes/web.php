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
    $report = [
        'environment' => app()->environment(),
        'php_version' => phpversion(),
        'config_session_driver' => config('session.driver'),
        'config_view_path' => config('view.compiled'),
        'ssl_cert_path_env' => env('MYSQL_ATTR_SSL_CA'),
        'ssl_cert_file_exists_public' => file_exists(public_path('isrgrootx1.pem')),
        'ssl_cert_path_resolved' => file_exists(public_path('isrgrootx1.pem')) ? public_path('isrgrootx1.pem') : 'FALLBACK SYSTEM',
        'db_config_options' => \DB::connection()->getConfig('options'),
    ];

    try {
        // 1. Check Database WRITE Permission
        \DB::beginTransaction();
        try {
            $user = new \App\Models\User();
            $user->name = 'Test Write';
            $user->username = 'test_write_' . time();
            $user->password = 'password';
            $user->save();
            $report['database_write'] = "SUCCESS (ID: {$user->id})";
        } catch (\Exception $e) {
            $report['database_write'] = "FAILED: " . $e->getMessage();
        }
        \DB::rollBack();

        // 2. Check Sessions Table Existence
        try {
            $count = \DB::table('sessions')->count();
            $report['sessions_table'] = "EXISTS (Rows: $count)";
        } catch (\Exception $e) {
            $report['sessions_table'] = "MISSING/ERROR: " . $e->getMessage();
        }

        // 3. Check Session Writing
        try {
            session(['debug_test' => 'working']);
            $report['session_write'] = session('debug_test') === 'working' ? "SUCCESS" : "FAILED (Read verification failed)";
        } catch (\Exception $e) {
            $report['session_write'] = "FATAL: " . $e->getMessage();
        }

    } catch (\Exception $e) {
        $report['critical_error'] = $e->getMessage();
    }

// Seeder Route for Vercel
Route::get('/seed-users', function () {
    try {
        // 1. CS User
        \App\Models\User::updateOrCreate(
            ['username' => 'afnan'],
            [
                'name' => 'Afnan (CS)',
                'email' => 'afnan@grapara.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'cs'
            ]
        );

        // 2. Manager User
        \App\Models\User::updateOrCreate(
            ['username' => 'faris'],
            [
                'name' => 'Faris (Manager)',
                'email' => 'faris@grapara.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'manager'
            ]
        );

        // 3. Admin User
        \App\Models\User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'email' => 'admin@grapara.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'admin'
            ]
        );

        return "Users Seeded Successfully! <br> afnan/password (CS) <br> faris/password (Manager) <br> admin/password (Admin)";
    } catch (\Exception $e) {
        return "Seeding Failed: " . $e->getMessage();
    }
});
