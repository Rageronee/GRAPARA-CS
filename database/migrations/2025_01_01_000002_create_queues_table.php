<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number'); // A-001
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); // Link to registered user
            $table->enum('status', ['waiting', 'calling', 'serving', 'completed', 'skipped'])->default('waiting');

            $table->foreignId('service_id')->constrained('services');
            $table->foreignId('served_by_user_id')->nullable()->constrained('users'); // CS who served
            $table->foreignId('counter_id')->nullable(); // Desk/Counter ID

            $table->timestamp('called_at')->nullable();
            $table->timestamp('served_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('queues');
    }
};
