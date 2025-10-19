<?php

require_once __DIR__ . '/../config/constants.php';

// Start session once for all routes
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define base path to views
$baseViewPath = __DIR__ . '/../src/views/';

// Determine requested page
$page = $_GET['page'] ?? 'users-login'; // Default to login

// Route map
$routes = [
    'users-login'             => $baseViewPath . 'users/login.php',
    'users-register'          => $baseViewPath . 'users/register.php',
    'users-profile'           => $baseViewPath . 'users/profile.php',
    'post-create'       => $baseViewPath . 'posts/create.php',
    'post-index'        => $baseViewPath . 'posts/index.php',
    'post-show'         => $baseViewPath . 'posts/show.php',
    'categories-index'  => $baseViewPath . 'categories/index.php',
    'categories-show'   => $baseViewPath . 'categories/show.php',
    // Add more views here as needed
];

// Validate and include
if (array_key_exists($page, $routes)) {
    require_once $routes[$page];
} else {
    // Fallback for unknown routes
    echo '<div class="alert-custom alert-error text-center">404 — Page not found</div>';
}