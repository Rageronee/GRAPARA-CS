<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');

            // Force Serverless-Safe Configurations
            config(['session.driver' => 'cookie']); // Safe fallback to unblock boot if DB fails
            config(['session.secure' => true]);     // Secure cookies
            config(['logging.default' => 'stderr']); // Log to Vercel console
            config(['view.compiled' => '/tmp']);    // Writable tmp dir for views

            // --- AUTO-HEALING: Schema & Data Repair on Boot ---
            // This replaces the need for manual /patch-db or /seed-users urls
            try {
                // 1. Schema Patch (Fix missing columns)
                if (\Illuminate\Support\Facades\Schema::hasTable('queues')) {
                    if (!\Illuminate\Support\Facades\Schema::hasColumn('queues', 'user_id')) {
                        \Illuminate\Support\Facades\Schema::table('queues', function ($table) {
                            $table->foreignId('user_id')->nullable()->after('ticket_number');
                        });
                    }
                    if (!\Illuminate\Support\Facades\Schema::hasColumn('queues', 'issue_detail')) {
                        \Illuminate\Support\Facades\Schema::table('queues', function ($table) {
                            $table->text('issue_detail')->nullable()->after('customer_phone');
                        });
                    }
                    if (!\Illuminate\Support\Facades\Schema::hasColumn('queues', 'staff_response')) {
                        \Illuminate\Support\Facades\Schema::table('queues', function ($table) {
                            $table->text('staff_response')->nullable()->after('issue_detail');
                        });
                    }
                }

                // 2. Data Seeder (Ensure Services exist)
                if (\Illuminate\Support\Facades\Schema::hasTable('services') && \App\Models\Service::count() === 0) {
                    \App\Models\Service::create(['id' => 1, 'name' => 'Customer Service', 'code' => 'A', 'description' => 'Layanan Umum']);
                    \App\Models\Service::create(['id' => 2, 'name' => 'Teller', 'code' => 'B', 'description' => 'Pembayaran']);
                    \App\Models\Service::create(['id' => 3, 'name' => 'Priority Tech', 'code' => 'C', 'description' => 'Gangguan Teknis']);

                    // Counters
                    \App\Models\Counter::create(['id' => 1, 'name' => 'Counter 1', 'status' => 'active']);
                    \App\Models\Counter::create(['id' => 2, 'name' => 'Counter 2', 'status' => 'active']);
                    \App\Models\Counter::create(['id' => 3, 'name' => 'Counter 3', 'status' => 'active']);

                    // Users (If empty)
                    if (\App\Models\User::count() === 0) {
                        \App\Models\User::create(['name' => 'Customer Service', 'username' => 'afnan', 'email' => 'afnan@grapara.com', 'password' => \Illuminate\Support\Facades\Hash::make('password'), 'role' => 'cs']);
                        \App\Models\User::create(['name' => 'Manager Area', 'username' => 'faris', 'email' => 'faris@grapara.com', 'password' => \Illuminate\Support\Facades\Hash::make('password'), 'role' => 'manager']);
                        \App\Models\User::create(['name' => 'Administrator', 'username' => 'admin', 'email' => 'admin@grapara.com', 'password' => \Illuminate\Support\Facades\Hash::make('password'), 'role' => 'admin']);
                    }
                }
            } catch (\Exception $e) {
                // Log silently to stderr so valid requests don't crash
                error_log("Auto-Heal Error: " . $e->getMessage());
            }
        }
    }
}
