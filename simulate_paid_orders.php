<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Order;

echo "=== SIMULASI: Update Order Pending ke Paid ===\n\n";

// Get all pending orders
$pendingOrders = Order::where('status', 'pending')->get();

if ($pendingOrders->isEmpty()) {
    echo "Tidak ada order dengan status pending.\n";
    exit;
}

echo "Ditemukan {$pendingOrders->count()} order pending:\n\n";

foreach ($pendingOrders as $order) {
    echo "- Order #{$order->order_number} | Total: Rp " . number_format($order->total, 0, ',', '.') . "\n";
}

echo "\n";

// Update 50% of pending orders to paid (random selection)
$ordersToPay = $pendingOrders->random(min(ceil($pendingOrders->count() / 2), $pendingOrders->count()));

echo "Mengubah " . $ordersToPay->count() . " order menjadi PAID...\n\n";

foreach ($ordersToPay as $order) {
    $order->update([
        'status' => 'paid',
        'progress_stage' => 2,
        'updated_at' => now(),
    ]);
    
    echo "✓ Order #{$order->order_number} -> Status: PAID\n";
}

echo "\n=== Simulasi Selesai ===\n";
echo "Total order PAID: " . Order::where('status', 'paid')->count() . "\n";
echo "Total order PENDING: " . Order::where('status', 'pending')->count() . "\n";
