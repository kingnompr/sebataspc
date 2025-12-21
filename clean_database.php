<?php

echo "=== CLEAN DATABASE SEBATAS PC ===\n\n";

try {
    // Connect to database
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=sebatas_pc', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✓ Connected to sebatas_pc database\n";
    
    // Disable foreign key checks
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    echo "✓ Disabled foreign key checks\n";
    
    // Get all tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "\nDropping " . count($tables) . " tables:\n";
    
    // Drop each table
    foreach ($tables as $table) {
        try {
            $pdo->exec("DROP TABLE IF EXISTS `$table`");
            echo "  ✓ Dropped table: $table\n";
        } catch (Exception $e) {
            echo "  ❌ Error dropping $table: " . $e->getMessage() . "\n";
        }
    }
    
    // Re-enable foreign key checks
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    echo "\n✓ Re-enabled foreign key checks\n";
    
    echo "\n=== SUCCESS ===\n";
    echo "All tables have been dropped.\n";
    echo "Now run: php artisan migrate --seed\n\n";
    
} catch (PDOException $e) {
    echo "\n❌ ERROR: " . $e->getMessage() . "\n\n";
    exit(1);
}
