<?php

namespace App\Core;

use App\Core\Database;
use App\Core\Router;
use App\Core\Config;

/**
 * Main Application Class
 * Handles application initialization and request processing
 */
class Application
{
    private static ?Application $instance = null;
    private Router $router;
    private Database $database;
    private Config $config;

    private function __construct()
    {
        $this->config = new Config();
        $this->database = new Database($this->config);
        $this->router = new Router();
    }

    /**
     * Get singleton instance
     */
    public static function getInstance(): Application
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Initialize the application
     */
    public function init(): void
    {
        // Set error reporting based on environment
        if ($this->config->get('APP_DEBUG', false)) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        } else {
            error_reporting(0);
            ini_set('display_errors', 0);
        }

        // Set timezone
        date_default_timezone_set($this->config->get('APP_TIMEZONE', 'UTC'));

        // Start session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Load routes
        $this->loadRoutes();
    }

    /**
     * Run the application
     */
    public function run(): void
    {
        try {
            $this->router->dispatch();
        } catch (\Exception $e) {
            $this->handleException($e);
        }
    }

    /**
     * Get router instance
     */
    public function getRouter(): Router
    {
        return $this->router;
    }

    /**
     * Get database instance
     */
    public function getDatabase(): Database
    {
        return $this->database;
    }

    /**
     * Get config instance
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * Load application routes
     */
    private function loadRoutes(): void
    {
        require_once __DIR__ . '/../routes/web.php';
    }

    /**
     * Handle application exceptions
     */
    private function handleException(\Exception $e): void
    {
        if ($this->config->get('APP_DEBUG', false)) {
            echo "<h1>Application Error</h1>";
            echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
            echo "<p><strong>File:</strong> " . $e->getFile() . "</p>";
            echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
            echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
        } else {
            http_response_code(500);
            echo "<h1>Internal Server Error</h1>";
            echo "<p>Something went wrong. Please try again later.</p>";
        }
    }
}
