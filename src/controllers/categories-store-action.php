<?php

require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/../../config/conn.php';
require_once __DIR__ . '/../controllers/CategoryController.php';

if (!defined('BASE_PATH')) {
    exit('Direct access not allowed.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = connectDB();

    $name = trim($_POST['name'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $description = trim($_POST['description'] ?? '');

    // Access control
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Sr Administrator') {
        $_SESSION['category_error'] = "Unauthorized access.";
        header('Location: ' . BASE_PATH . 'index.php?page=categories-index');
        exit;
    }

    // Basic validation
    if ($name === '' || $slug === '') {
        $_SESSION['category_error'] = "Name and slug are required.";
        header('Location: ' . BASE_PATH . 'index.php?page=categories-create');
        exit;
    }

    $success = CategoryController::store($conn, $name, $slug, $description);

    if ($success) {
        $_SESSION['category_success'] = "Category created successfully.";
        header('Location: ' . BASE_PATH . 'index.php?page=categories-index');
    } else {
        $_SESSION['category_error'] = "Failed to create category.";
        header('Location: ' . BASE_PATH . 'index.php?page=categories-create');
    }

    exit;
} 
else {
    $_SESSION['category_error'] = "Invalid request method.";
    header('Location: ' . BASE_PATH . 'index.php?page=categories-index');
    exit;
}