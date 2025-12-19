<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Cek apakah ada user admin
$admin = App\Models\User::where('is_admin', true)->first();

echo "=== CEK USER ADMIN ===\n\n";

if ($admin) {
    echo " Admin user exists:\n";
    echo "   Name: {$admin->name}\n";
    echo "   Email: {$admin->email}\n";
} else {
    echo " No admin user found!\n";
    echo "Creating admin user...\n\n";
    
    // Create admin user
    $admin = App\Models\User::create([
        'name' => 'Admin',
        'email' => 'admin@sebataspc.com',
        'password' => bcrypt('admin123'),
        'phone' => '081234567890',
        'is_admin' => true,
    ]);
    
    echo " Admin created successfully!\n";
    echo "   Email: admin@sebataspc.com\n";
    echo "   Password: admin123\n";
}

echo "\n=== LOGIN CREDENTIALS ===\n";
echo "URL: http://127.0.0.1:8000/admin\n";
echo "Email: {$admin->email}\n";
echo "Password: admin123\n";
