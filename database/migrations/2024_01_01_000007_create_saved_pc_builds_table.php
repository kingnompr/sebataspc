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
        Schema::create('saved_pc_builds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pc_build_id')->constrained()->cascadeOnDelete();
            $table->string('custom_name')->nullable();
            $table->unsignedTinyInteger('progress_percent')->default(0);
            $table->timestamp('last_interacted_at')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'pc_build_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saved_pc_builds');
    }
};
