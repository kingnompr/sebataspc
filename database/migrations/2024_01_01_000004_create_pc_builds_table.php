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
        Schema::create('pc_builds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('budget_min', 12, 2);
            $table->decimal('budget_max', 12, 2);
            $table->string('performance_tier'); // Budget, Mid, High, Extreme
            $table->string('use_case'); // Gaming, Editing, Streaming, Office
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('pc_build_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pc_build_id')->constrained()->onDelete('cascade');
            $table->string('component_type'); // CPU, GPU, RAM, Storage, PSU, Motherboard, Case
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pc_build_components');
        Schema::dropIfExists('pc_builds');
    }
};
