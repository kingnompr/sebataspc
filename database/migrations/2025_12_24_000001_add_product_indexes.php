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
        Schema::table('products', function (Blueprint $table) {
            // Add indexes for common queries
            $table->index('category_id');
            $table->index('is_featured');
            $table->index('stock');
            $table->index(['category_id', 'stock']); // Composite index for category + stock queries
            $table->index(['category_id', 'is_featured']); // Composite for featured by category
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['category_id']);
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['stock']);
            $table->dropIndex(['category_id', 'stock']);
            $table->dropIndex(['category_id', 'is_featured']);
        });
    }
};
