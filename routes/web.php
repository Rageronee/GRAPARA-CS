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

// --- SUPABASE MIGRATOR ---
// This route runs migrations and seeds data for the new PostgreSQL DB
Route::get('/setup-db', function () {
    try {
        $output = "<h1>Setup Database (Supabase/PostgreSQL)</h1>";

        // 1. Create Tables (Simulated Migration)
        $output .= "<h3>1. Schema Check</h3>";

        if (!Schema::hasTable('users')) {
            Schema::create('users', function ($table) {
                $table->id();
                $table->string('name');
                $table->string('username')->unique(); // 'cs', 'manager'
                $table->string('email')->nullable();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->string('role')->default('user'); // admin, manager, cs, user
                $table->rememberToken();
                $table->timestamps();
            });
            $output .= "✅ Created 'users' table.<br>";
        }

        if (!Schema::hasTable('services')) {
            Schema::create('services', function ($table) {
                $table->id();
                $table->string('name');
                $table->string('code')->default('A');
                $table->string('description')->nullable();
                $table->timestamps();
            });
            $output .= "✅ Created 'services' table.<br>";
        }

        if (!Schema::hasTable('counters')) {
            Schema::create('counters', function ($table) {
                $table->id();
                $table->string('name');
                $table->boolean('status')->default(true); // active/inactive
                $table->timestamps();
            });
            $output .= "✅ Created 'counters' table.<br>";
        }

        if (!Schema::hasTable('queues')) {
            Schema::create('queues', function ($table) {
                $table->id();
                $table->string('ticket_number'); // A-001
                $table->foreignId('user_id')->nullable(); // Link to registered user
                $table->string('customer_name')->nullable();
                $table->string('customer_phone')->nullable();
                $table->text('issue_detail')->nullable();

                $table->enum('status', ['waiting', 'calling', 'serving', 'completed', 'skipped', 'cancelled'])->default('waiting');

                $table->foreignId('service_id');
                $table->foreignId('served_by_user_id')->nullable(); // CS ID
                $table->foreignId('counter_id')->nullable();

                $table->text('staff_response')->nullable();
                $table->integer('rating')->nullable();
                $table->text('feedback')->nullable();

                $table->timestamp('called_at')->nullable();
                $table->timestamp('served_at')->nullable();
                $table->timestamp('completed_at')->nullable();
                $table->timestamps();
            });
            $output .= "✅ Created 'queues' table.<br>";
        }

        // 2. Seed Data
        $output .= "<h3>2. Seeding Data</h3>";

        // Manager Account
        \App\Models\User::updateOrCreate(
            ['username' => 'manager'],
            [
                'name' => 'Manager Area',
                'email' => 'manager@grapara.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'manager'
            ]
        );
        $output .= "✅ User 'manager' ready (Pass: password).<br>";

        // CS Account
        \App\Models\User::updateOrCreate(
            ['username' => 'cs'],
            [
                'name' => 'Customer Service',
                'email' => 'cs@grapara.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'cs'
            ]
        );
        $output .= "✅ User 'cs' ready (Pass: password).<br>";

        // Services
        \App\Models\Service::updateOrCreate(['id' => 1], ['name' => 'Customer Service', 'code' => 'A', 'description' => 'Layanan Umum']);
        \App\Models\Service::updateOrCreate(['id' => 2], ['name' => 'Teller', 'code' => 'B', 'description' => 'Pembayaran']);
        \App\Models\Service::updateOrCreate(['id' => 3], ['name' => 'Priority Tech', 'code' => 'C', 'description' => 'Gangguan Teknis']);
        $output .= "✅ Services (A, B, C) ready.<br>";

        // Counters
        \App\Models\Counter::updateOrCreate(['id' => 1], ['name' => 'Counter 1', 'status' => true]);
        \App\Models\Counter::updateOrCreate(['id' => 2], ['name' => 'Counter 2', 'status' => true]);
        \App\Models\Counter::updateOrCreate(['id' => 3], ['name' => 'Counter 3', 'status' => true]);
        $output .= "✅ Counters (1-3) ready.<br>";

        return $output . "<br><h3>🎉 SUCCESS! Database is ready.</h3><a href='/'>Go to Home</a>";

    } catch (\Exception $e) {
        return "<h3>❌ SETUP FAILED</h3>" . $e->getMessage() . "<br><pre>" . $e->getTraceAsString() . "</pre>";
    }
});
