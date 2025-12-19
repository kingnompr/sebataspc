<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('custom_pc_builds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('session_id')->nullable();
            $table->string('build_name')->default('My PC Build');
            $table->decimal('budget', 12, 2)->nullable();
            $table->string('use_case')->nullable(); // gaming, office, editing
            $table->string('tier')->nullable(); // best_performance, best_value, future_proof
            $table->json('components'); // Store selected component IDs
            $table->decimal('total_price', 12, 2)->default(0);
            $table->timestamps();
            
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_pc_builds');
    }
};
