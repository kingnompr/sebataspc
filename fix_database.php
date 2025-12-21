<?php

echo "=== FIX DATABASE SEBATAS PC ===\n\n";

try {
    // Connect to MySQL without selecting database
    $pdo = new PDO('mysql:host=127.0.0.1', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✓ Connected to MySQL\n";
    
    // Drop database if exists
    $pdo->exec("DROP DATABASE IF EXISTS sebatas_pc");
    echo "✓ Dropped old database (if exists)\n";
    
    // Create fresh database
    $pdo->exec("CREATE DATABASE sebatas_pc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✓ Created fresh database sebatas_pc\n";
    
    echo "\n=== SUCCESS ===\n";
    echo "Database sebatas_pc has been recreated.\n";
    echo "Now run: php artisan migrate --seed\n\n";
    
} catch (PDOException $e) {
    echo "\n❌ ERROR: " . $e->getMessage() . "\n\n";
    exit(1);
}
