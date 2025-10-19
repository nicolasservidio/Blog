<?php
// Start session once for all routes
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define base path to views
$baseViewPath = __DIR__ . '/../src/views/';

// Determine requested page
$page = $_GET['page'] ?? 'login'; // Default to login

// Route map
$routes = [
    'login'             => $baseViewPath . 'users/login.php',
    'register'          => $baseViewPath . 'users/register.php',
    'profile'           => $baseViewPath . 'users/profile.php',
    'create-post'       => $baseViewPath . 'posts/create.php',
    'index-post'        => $baseViewPath . 'posts/index.php',
    'show-post'         => $baseViewPath . 'posts/show.php',
    'index-categories'  => $baseViewPath . 'categories/index.php',
    'show-categories'   => $baseViewPath . 'categories/show.php',
    // Add more views here as needed
];

// Validate and include
if (array_key_exists($page, $routes)) {
    require_once $routes[$page];
} else {
    // Fallback for unknown routes
    echo '<div class="alert-custom alert-error text-center">404 — Page not found</div>';
}