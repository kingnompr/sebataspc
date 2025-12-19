<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== CEK & UPDATE USER ADMIN ===\n\n";

// Cek apakah user admin exists
$user = User::where('email', 'admin@sebataspc.com')->first();

if ($user) {
    echo "✓ User ditemukan:\n";
    echo "  Name: {$user->name}\n";
    echo "  Email: {$user->email}\n";
    echo "  Is Admin: " . ($user->is_admin ? 'Yes' : 'No') . "\n";
    echo "  Password Hash: " . substr($user->password, 0, 30) . "...\n\n";
    
    // Update password dan is_admin
    echo "Updating password dan is_admin flag...\n";
    $user->password = Hash::make('admin123');
    $user->is_admin = true;
    $user->save();
    
    echo "✅ User berhasil diupdate!\n\n";
    
} else {
    echo "✗ User tidak ditemukan. Membuat user baru...\n\n";
    
    $user = User::create([
        'name' => 'Administrator',
        'email' => 'admin@sebataspc.com',
        'password' => Hash::make('admin123'),
        'is_admin' => true,
    ]);
    
    echo "✅ User admin berhasil dibuat!\n\n";
}

// Test password
echo "Testing password 'admin123'...\n";
if (Hash::check('admin123', $user->password)) {
    echo "✅ Password BENAR - bisa login!\n\n";
} else {
    echo "❌ Password SALAH - ada masalah!\n\n";
}

echo "=== CREDENTIAL LOGIN ===\n";
echo "Email: admin@sebataspc.com\n";
echo "Password: admin123\n";
echo "URL: http://127.0.0.1:8000/login\n\n";

echo "Done!\n";
