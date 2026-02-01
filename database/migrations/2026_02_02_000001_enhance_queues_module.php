<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Complaint Categories
        Schema::create('complaint_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('sla_minutes')->default(30); // Default 30 mins to resolve
            $table->timestamps();
        });

        // 2. Queue Logs (Audit Trail)
        Schema::create('queue_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('queue_id')->constrained('queues')->onDelete('cascade');
            $table->foreignId('actor_id')->nullable()->constrained('users'); // User who performed action
            $table->string('action'); // e.g., 'status_change', 'created'
            $table->json('payload')->nullable(); // Old/New values
            $table->timestamps();
        });

        // 3. Update Queues Table
        Schema::table('queues', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained('complaint_categories');

            // Compound Index for "Get Next Ticket" query performance
            // Priority: status (equality) -> service_id (equality/sort) -> created_at (sort)
            $table->index(['status', 'service_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::table('queues', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
            $table->dropIndex(['status', 'service_id', 'created_at']);
        });

        Schema::dropIfExists('queue_logs');
        Schema::dropIfExists('complaint_categories');
    }
};
