<?php

// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set the document root
define('ROOT_PATH', dirname(__DIR__));

// Include Composer autoloader
require_once ROOT_PATH . '/vendor/autoload.php';

// Include application bootstrap
require_once ROOT_PATH . '/src/Core/Application.php';

use App\Core\Application;

try {
    // Initialize and run the application
    $app = Application::getInstance();
    $app->init();
    $app->run();
} catch (Exception $e) {
    // Handle fatal errors
    http_response_code(500);
    echo "<h1>Application Error</h1>";
    echo "<p>An error occurred while running the application.</p>";
    
    if (ini_get('display_errors')) {
        echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p><strong>File:</strong> " . $e->getFile() . "</p>";
        echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
    }
}
