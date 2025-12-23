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
        Schema::table('reviews', function (Blueprint $table) {
            $table->json('images')->nullable()->after('comment');
            $table->boolean('is_helpful')->default(false)->after('is_verified_purchase');
            $table->integer('helpful_count')->default(0)->after('is_helpful');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['images', 'is_helpful', 'helpful_count']);
        });
    }
};
