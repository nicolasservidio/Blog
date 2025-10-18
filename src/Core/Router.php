<?php

namespace App\Core;

/**
 * Router Class
 * Handles URL routing and request dispatching
 */
class Router
{
    private array $routes = [];
    private array $middleware = [];

    /**
     * Add GET route
     */
    public function get(string $path, string $controller, string $method = 'index'): void
    {
        $this->addRoute('GET', $path, $controller, $method);
    }

    /**
     * Add POST route
     */
    public function post(string $path, string $controller, string $method = 'index'): void
    {
        $this->addRoute('POST', $path, $controller, $method);
    }

    /**
     * Add PUT route
     */
    public function put(string $path, string $controller, string $method = 'index'): void
    {
        $this->addRoute('PUT', $path, $controller, $method);
    }

    /**
     * Add DELETE route
     */
    public function delete(string $path, string $controller, string $method = 'index'): void
    {
        $this->addRoute('DELETE', $path, $controller, $method);
    }

    /**
     * Add route with middleware
     */
    public function middleware(array $middleware, callable $callback): void
    {
        $this->middleware = array_merge($this->middleware, $middleware);
        $callback($this);
        $this->middleware = [];
    }

    /**
     * Add route
     */
    private function addRoute(string $method, string $path, string $controller, string $action): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action,
            'middleware' => $this->middleware
        ];
    }

    /**
     * Dispatch request to appropriate controller
     */
    public function dispatch(): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Remove trailing slash
        $requestUri = rtrim($requestUri, '/');
        if (empty($requestUri)) {
            $requestUri = '/';
        }

        foreach ($this->routes as $route) {
            if ($this->matchRoute($route, $requestMethod, $requestUri)) {
                $this->executeRoute($route, $this->extractParams($route['path'], $requestUri));
                return;
            }
        }

        // No route found
        $this->handleNotFound();
    }

    /**
     * Check if route matches request
     */
    private function matchRoute(array $route, string $method, string $uri): bool
    {
        if ($route['method'] !== $method) {
            return false;
        }

        $pattern = $this->convertToRegex($route['path']);
        return preg_match($pattern, $uri);
    }

    /**
     * Convert route path to regex pattern
     */
    private function convertToRegex(string $path): string
    {
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $path);
        return '#^' . $pattern . '$#';
    }

    /**
     * Extract parameters from URI
     */
    private function extractParams(string $path, string $uri): array
    {
        $params = [];
        $pathSegments = explode('/', $path);
        $uriSegments = explode('/', $uri);

        foreach ($pathSegments as $index => $segment) {
            if (preg_match('/\{([^}]+)\}/', $segment, $matches)) {
                $paramName = $matches[1];
                $params[$paramName] = $uriSegments[$index] ?? null;
            }
        }

        return $params;
    }

    /**
     * Execute route
     */
    private function executeRoute(array $route, array $params): void
    {
        // Execute middleware
        foreach ($route['middleware'] as $middlewareClass) {
            $middleware = new $middlewareClass();
            if (!$middleware->handle()) {
                return;
            }
        }

        // Instantiate controller
        $controllerClass = "App\\Controllers\\{$route['controller']}";
        
        if (!class_exists($controllerClass)) {
            throw new \Exception("Controller {$controllerClass} not found");
        }

        $controller = new $controllerClass();
        $action = $route['action'];

        if (!method_exists($controller, $action)) {
            throw new \Exception("Method {$action} not found in {$controllerClass}");
        }

        // Call controller method with parameters
        call_user_func_array([$controller, $action], $params);
    }

    /**
     * Handle 404 Not Found
     */
    private function handleNotFound(): void
    {
        http_response_code(404);
        echo "<h1>404 - Page Not Found</h1>";
        echo "<p>The requested page could not be found.</p>";
    }
}
