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
    'login-action'            => __DIR__ . '/../src/controllers/LoginController.php',
    'register-action'         => __DIR__ . '/../src/controllers/RegisterController.php',
    'post-create-action'      => __DIR__ . '/../src/controllers/post-create-action.php',
    'post-edit'               => $baseViewPath . 'posts/post-edit.php',
    'post-update-action'      => __DIR__ . '/../src/controllers/post-update-action.php',
    'post-delete-action'      => __DIR__ . '/../src/controllers/post-delete-action.php',
    'users-login'             => $baseViewPath . 'users/login.php',
    'users-register'          => $baseViewPath . 'users/register.php',
    'users-profile'           => $baseViewPath . 'users/profile.php',
    'users-logout'            => $baseViewPath . 'users/logout.php',
    'post-index'        => $baseViewPath . 'posts/index.php',
    'post-create'       => $baseViewPath . 'posts/create.php',
    'post-show'         => $baseViewPath . 'posts/show.php',
    'categories-index'  => $baseViewPath . 'categories/index.php',
    'categories-show'   => $baseViewPath . 'categories/show.php',
    // Add more views here as needed
];

// Validate and include
if (array_key_exists($page, $routes)) {
    // Detect if it's a controller (logical action) or a view (page to be seen)
    if (str_ends_with($page, '-action')) {
        include $routes[$page]; // Run the controller
        exit; // Prevents additional layout or content from loading
    } else {
        require_once $routes[$page]; // Load the view in a normal way
    }
} else {
    echo '<div class="alert-custom alert-error text-center">404 — Page not found</div>';
}
