<?php

// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set the document root
define('ROOT_PATH', dirname(__DIR__));

// Manually include all required files
require_once ROOT_PATH . '/src/Core/Application.php';
require_once ROOT_PATH . '/src/Core/Config.php';
require_once ROOT_PATH . '/src/Core/Database.php';
require_once ROOT_PATH . '/src/Core/Router.php';
require_once ROOT_PATH . '/src/Core/Controller.php';
require_once ROOT_PATH . '/src/Core/Model.php';

require_once ROOT_PATH . '/src/Models/User.php';
require_once ROOT_PATH . '/src/Models/Post.php';
require_once ROOT_PATH . '/src/Models/Category.php';

require_once ROOT_PATH . '/src/Controllers/HomeController.php';
require_once ROOT_PATH . '/src/Controllers/AuthController.php';
require_once ROOT_PATH . '/src/Controllers/BlogController.php';
require_once ROOT_PATH . '/src/Controllers/AdminController.php';

require_once ROOT_PATH . '/src/Middleware/AuthMiddleware.php';

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
