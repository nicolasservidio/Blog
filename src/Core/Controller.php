<?php

namespace App\Core;

/**
 * Base Controller Class
 * Provides common functionality for all controllers
 */
abstract class Controller
{
    protected Database $db;
    protected Config $config;

    public function __construct()
    {
        $app = Application::getInstance();
        $this->db = $app->getDatabase();
        $this->config = $app->getConfig();
    }

    /**
     * Render a view
     */
    protected function view(string $view, array $data = []): void
    {
        $viewPath = __DIR__ . "/../Views/{$view}.php";
        
        if (!file_exists($viewPath)) {
            throw new \Exception("View {$view} not found");
        }

        // Extract data to variables
        extract($data);

        // Start output buffering
        ob_start();
        include $viewPath;
        $content = ob_get_clean();

        echo $content;
    }

    /**
     * Return JSON response
     */
    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    /**
     * Redirect to URL
     */
    protected function redirect(string $url, int $statusCode = 302): void
    {
        http_response_code($statusCode);
        header("Location: {$url}");
        exit;
    }

    /**
     * Get request data
     */
    protected function input(string $key = null, mixed $default = null): mixed
    {
        $data = array_merge($_GET, $_POST);
        
        if ($key === null) {
            return $data;
        }
        
        return $data[$key] ?? $default;
    }

    /**
     * Get request method
     */
    protected function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Check if request is POST
     */
    protected function isPost(): bool
    {
        return $this->method() === 'POST';
    }

    /**
     * Check if request is GET
     */
    protected function isGet(): bool
    {
        return $this->method() === 'GET';
    }

    /**
     * Validate CSRF token
     */
    protected function validateCsrf(): bool
    {
        $token = $this->input('_token');
        return $token && hash_equals($_SESSION['_token'] ?? '', $token);
    }

    /**
     * Generate CSRF token
     */
    protected function csrfToken(): string
    {
        if (!isset($_SESSION['_token'])) {
            $_SESSION['_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_token'];
    }

    /**
     * Set flash message
     */
    protected function flash(string $key, string $message): void
    {
        $_SESSION['flash'][$key] = $message;
    }

    /**
     * Get flash message
     */
    protected function getFlash(string $key): ?string
    {
        $message = $_SESSION['flash'][$key] ?? null;
        unset($_SESSION['flash'][$key]);
        return $message;
    }

    /**
     * Check if user is authenticated
     */
    protected function isAuthenticated(): bool
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Get authenticated user ID
     */
    protected function getUserId(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    /**
     * Require authentication
     */
    protected function requireAuth(): void
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
        }
    }
}
