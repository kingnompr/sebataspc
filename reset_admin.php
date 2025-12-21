<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== CHECKING ADMIN USER ===\n\n";

// Check if admin exists
$admin = User::where('email', 'admin@sebataspc.com')->first();

if ($admin) {
    echo "✅ Admin user found!\n";
    echo "   Email: {$admin->email}\n";
    echo "   Name: {$admin->name}\n";
    echo "   Is Admin: " . ($admin->is_admin ? 'YES' : 'NO') . "\n\n";
    
    // Update password and ensure is_admin is set
    $admin->password = Hash::make('admin123');
    $admin->is_admin = true;
    $admin->save();
    
    echo "✅ Password updated to: admin123\n";
    echo "✅ Admin flag set to: true\n\n";
    
    // Test the password
    if (Hash::check('admin123', $admin->password)) {
        echo "✅ Password verification: SUCCESS\n";
        echo "\n=== LOGIN CREDENTIALS ===\n";
        echo "Email: admin@sebataspc.com\n";
        echo "Password: admin123\n";
        echo "URL: http://127.0.0.1:8000/login\n";
    } else {
        echo "❌ Password verification: FAILED\n";
    }
} else {
    echo "❌ Admin user not found. Creating new admin...\n\n";
    
    $admin = User::create([
        'name' => 'Admin Sebatas PC',
        'email' => 'admin@sebataspc.com',
        'password' => Hash::make('admin123'),
        'is_admin' => true,
        'email_verified_at' => now(),
    ]);
    
    echo "✅ Admin user created!\n";
    echo "   Email: admin@sebataspc.com\n";
    echo "   Password: admin123\n";
}

echo "\nDone!\n";
