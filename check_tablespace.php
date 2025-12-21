<?php

echo "=== FIX TABLESPACE ISSUE ===\n\n";

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=sebatas_pc', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✓ Connected to database\n";
    
    // Try to discard tablespace for migrations table
    try {
        $pdo->exec("DROP TABLE IF EXISTS migrations");
        echo "✓ Dropped migrations table\n";
    } catch (Exception $e) {
        echo "! " . $e->getMessage() . "\n";
    }
    
    // Get data directory
    $stmt = $pdo->query("SELECT @@datadir");
    $datadir = $stmt->fetchColumn();
    echo "\nMySQL Data Directory: $datadir\n";
    
    // Check for orphaned files
    $dbPath = rtrim($datadir, '/\\') . DIRECTORY_SEPARATOR . 'sebatas_pc';
    echo "Database files location: $dbPath\n\n";
    
    if (is_dir($dbPath)) {
        $files = scandir($dbPath);
        $tablespaceFiles = array_filter($files, function($file) {
            return preg_match('/\.(ibd|frm)$/', $file);
        });
        
        if (count($tablespaceFiles) > 0) {
            echo "Found " . count($tablespaceFiles) . " orphaned tablespace files:\n";
            foreach ($tablespaceFiles as $file) {
                echo "  - $file\n";
            }
            echo "\nThese files need to be deleted manually.\n";
            echo "Please close MySQL/XAMPP and delete these files from:\n";
            echo "$dbPath\n";
        } else {
            echo "No orphaned tablespace files found.\n";
        }
    } else {
        echo "Database directory not found.\n";
    }
    
} catch (PDOException $e) {
    echo "\n❌ ERROR: " . $e->getMessage() . "\n\n";
}
