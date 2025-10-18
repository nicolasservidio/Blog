<?php

namespace App\Middleware;

/**
 * Authentication Middleware
 * Protects routes that require authentication
 */
class AuthMiddleware
{
    /**
     * Handle the middleware
     */
    public function handle(): bool
    {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return false;
        }

        return true;
    }
}
