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
        Schema::create('compatibility_rules', function (Blueprint $table) {
            $table->id();
            $table->string('rule_name'); // e.g., "CPU-Motherboard Socket Match"
            $table->string('component_type_a'); // e.g., "Processor"
            $table->string('component_type_b'); // e.g., "Motherboard"
            $table->string('rule_type'); // socket_match, memory_type_match, tdp_check, etc.
            $table->json('rule_conditions'); // Flexible JSON for various conditions
            $table->text('error_message')->nullable(); // Message when incompatible
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['component_type_a', 'component_type_b']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compatibility_rules');
    }
};
