<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\AuthController;

Route::get('/', [DashboardController::class, 'landing'])->name('home');

Route::view('/guide', 'guide')->name('guide');

// Authentication Routes
// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/cs/updates', [DashboardController::class, 'updates'])->name('cs.updates');

    // CS Routes
    Route::post('/cs/next', [QueueController::class, 'next'])->name('cs.next');
    Route::post('/queue/call/{queue}', [QueueController::class, 'callSpecific'])->name('queue.call_specific');
    Route::post('/queue/call-auto', [QueueController::class, 'callAuto'])->name('cs.call_auto');
    Route::post('/cs/complete/{queue}', [QueueController::class, 'complete'])->name('cs.complete');

    Route::post('/queue/{queue}/rate', [QueueController::class, 'rate'])->name('queue.rate');

    Route::get('/cs', [DashboardController::class, 'index']); // Alias

    // User History
    Route::get('/queue/history', [QueueController::class, 'history'])->name('queue.history');
    Route::post('/queue/{queue}/cancel', [QueueController::class, 'cancel'])->name('queue.cancel');
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

    return response()->json($report);
});

// Seeder Route for Vercel
Route::get('/seed-users', function () {
    try {
        // --- NEW REQUESTED ACCOUNTS ---

        // 1. Manager
        \App\Models\User::updateOrCreate(
            ['username' => 'manager'],
            [
                'name' => 'Manager Area',
                'email' => 'manager@grapara.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'manager'
            ]
        );

        // 2. CS
        \App\Models\User::updateOrCreate(
            ['username' => 'cs'],
            [
                'name' => 'Customer Service',
                'email' => 'cs@grapara.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'cs'
            ]
        );

        // --- EXISTING SETUP (Services & Counters) ---

        // Services
        \App\Models\Service::updateOrCreate(['id' => 1], ['name' => 'Customer Service', 'code' => 'A', 'description' => 'Layanan Umum']);
        \App\Models\Service::updateOrCreate(['id' => 2], ['name' => 'Teller', 'code' => 'B', 'description' => 'Pembayaran']);
        \App\Models\Service::updateOrCreate(['id' => 3], ['name' => 'Priority Tech', 'code' => 'C', 'description' => 'Gangguan Teknis']);

        // Counters
        \App\Models\Counter::updateOrCreate(['id' => 1], ['name' => 'Counter 1', 'status' => 'active']);
        \App\Models\Counter::updateOrCreate(['id' => 2], ['name' => 'Counter 2', 'status' => 'active']);
        \App\Models\Counter::updateOrCreate(['id' => 3], ['name' => 'Counter 3', 'status' => 'active']);

        return "ALL DATA SEEDED! <br> ACCOUNTS ADDED: <br> - super (pass: password) <br> - manager (pass: password) <br> - cs1, cs2, cs3 (pass: password)";
    } catch (\Exception $e) {
        return "Seeding Failed: " . $e->getMessage();
    }
});

// EMERGENCY DB PATCHER (Run Once)
Route::get('/patch-db', function () {
    try {
        $output = "Patching Database...<br>";

        // Add 'user_id'
        if (!Schema::hasColumn('queues', 'user_id')) {
            Schema::table('queues', function (Illuminate\Database\Schema\Blueprint $table) {
                $table->foreignId('user_id')->nullable()->after('ticket_number');
            });
            $output .= "- Added 'user_id' column.<br>";
        }

        // Add 'issue_detail'
        if (!Schema::hasColumn('queues', 'issue_detail')) {
            Schema::table('queues', function (Illuminate\Database\Schema\Blueprint $table) {
                $table->text('issue_detail')->nullable()->after('customer_phone');
            });
            $output .= "- Added 'issue_detail' column.<br>";
        }

        // Add 'staff_response'
        if (!Schema::hasColumn('queues', 'staff_response')) {
            Schema::table('queues', function (Illuminate\Database\Schema\Blueprint $table) {
                $table->text('staff_response')->nullable()->after('issue_detail');
            });
            $output .= "- Added 'staff_response' column.<br>";
        }

        return $output . "DONE! Database is now compatible.";
    } catch (\Exception $e) {
        return "Patch Failed: " . $e->getMessage();
    }
});
