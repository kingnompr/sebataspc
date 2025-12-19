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
            // General fields
            $table->string('brand')->nullable()->after('category_id');
            $table->string('model')->nullable()->after('brand');
            $table->string('sku')->nullable()->unique()->after('model');
            
            // CPU/Motherboard compatibility
            $table->string('socket')->nullable()->after('specifications'); // LGA1700, AM5, etc.
            $table->string('chipset')->nullable()->after('socket'); // Z690, B550, etc.
            
            // RAM compatibility
            $table->string('memory_type')->nullable()->after('chipset'); // DDR4, DDR5
            $table->integer('memory_speed')->nullable()->after('memory_type'); // 3200, 6000, etc.
            $table->integer('memory_slots')->nullable()->after('memory_speed'); // For motherboards
            
            // Storage compatibility
            $table->string('interface')->nullable()->after('memory_slots'); // NVMe, SATA, M.2
            $table->integer('capacity_gb')->nullable()->after('interface'); // Storage capacity
            
            // Power consumption
            $table->integer('tdp')->nullable()->after('capacity_gb'); // Thermal Design Power (Watts)
            $table->integer('wattage')->nullable()->after('tdp'); // For PSU
            $table->string('efficiency_rating')->nullable()->after('wattage'); // 80+ Bronze, Gold, etc.
            
            // Physical dimensions
            $table->string('form_factor')->nullable()->after('efficiency_rating'); // ATX, mATX, ITX, etc.
            $table->integer('length_mm')->nullable()->after('form_factor'); // For GPU/Casing
            $table->integer('height_mm')->nullable()->after('length_mm');
            
            // Additional compatibility fields
            $table->json('compatible_sockets')->nullable()->after('height_mm'); // Array of compatible sockets
            $table->json('supported_memory_types')->nullable()->after('compatible_sockets');
            $table->boolean('rgb_support')->default(false)->after('supported_memory_types');
            
            // Stock management
            $table->integer('min_stock_alert')->default(5)->after('stock');
            $table->date('last_restock_date')->nullable()->after('min_stock_alert');
            
            // Pricing
            $table->decimal('cost_price', 12, 2)->nullable()->after('price'); // Harga modal
            $table->decimal('markup_percentage', 5, 2)->default(0)->after('cost_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'brand', 'model', 'sku',
                'socket', 'chipset',
                'memory_type', 'memory_speed', 'memory_slots',
                'interface', 'capacity_gb',
                'tdp', 'wattage', 'efficiency_rating',
                'form_factor', 'length_mm', 'height_mm',
                'compatible_sockets', 'supported_memory_types', 'rgb_support',
                'min_stock_alert', 'last_restock_date',
                'cost_price', 'markup_percentage'
            ]);
        });
    }
};
