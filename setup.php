<?php
/**
 * Database Setup Script
 * Run this script to set up the database and create initial data
 */

require_once 'vendor/autoload.php';
require_once 'src/Core/Application.php';

use App\Core\Application;

try {
    echo "Setting up database...\n";
    
    // Initialize application
    $app = Application::getInstance();
    $app->init();
    
    $db = $app->getDatabase();
    
    // Read and execute migration files
    $migrationFiles = glob('database/migrations/*.sql');
    sort($migrationFiles);
    
    foreach ($migrationFiles as $file) {
        echo "Running migration: " . basename($file) . "\n";
        $sql = file_get_contents($file);
        $db->query($sql);
    }
    
    // Read and execute seed files
    $seedFiles = glob('database/seeds/*.sql');
    sort($seedFiles);
    
    foreach ($seedFiles as $file) {
        echo "Running seed: " . basename($file) . "\n";
        $sql = file_get_contents($file);
        $db->query($sql);
    }
    
    echo "Database setup completed successfully!\n";
    echo "You can now access the blog at: http://localhost:8000\n";
    echo "Admin login: admin@blog.com / password\n";
    
} catch (Exception $e) {
    echo "Error setting up database: " . $e->getMessage() . "\n";
    exit(1);
}
