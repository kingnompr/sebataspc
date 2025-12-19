<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== UPDATE USER ADMIN ===\n\n";

// Update existing user to admin
$admin = App\Models\User::where('email', 'admin@sebataspc.com')->first();

if ($admin) {
    $admin->is_admin = true;
    $admin->save();
    echo " User updated to admin:\n";
} else {
    // Create new admin
    $admin = App\Models\User::create([
        'name' => 'Admin Sebatas PC',
        'email' => 'admin@sebataspc.com',
        'password' => bcrypt('admin123'),
        'phone' => '081234567890',
        'is_admin' => true,
    ]);
    echo " New admin created:\n";
}

echo "   Name: {$admin->name}\n";
echo "   Email: {$admin->email}\n";
echo "   Is Admin: " . ($admin->is_admin ? 'Yes' : 'No') . "\n";

echo "\n=== LOGIN INFO ===\n";
echo "URL: http://127.0.0.1:8000/login\n";
echo "Email: {$admin->email}\n";
echo "Password: admin123\n";
echo "\nSetelah login, akses: http://127.0.0.1:8000/admin\n";
