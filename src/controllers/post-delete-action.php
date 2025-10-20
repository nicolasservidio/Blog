<?php

require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/../../config/conn.php';
require_once __DIR__ . '/../controllers/PostController.php';

if (!defined('BASE_PATH')) {
    exit('Direct access not allowed.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = connectDB();
    $id = intval($_POST['id'] ?? 0);

    // Access control
    $original = PostController::edit($conn, $id);
    $post = $original['post'] ?? null;

    $isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    $isAuthor = isset($_SESSION['user']) && $_SESSION['user']['id'] == ($post['author_id'] ?? null);

    if (!$post || (!$isAdmin && !$isAuthor)) {
        
        $_SESSION['delete_post_error'] = "Unauthorized deletion attempt.";
        header('Location: ' . BASE_PATH . 'index.php?page=users-profile');
        exit;
    }

    $success = PostController::archive($conn, $id);

    if ($success) {
        $_SESSION['delete_post_success'] = "Post archived successfully.";
    } else {
        $_SESSION['delete_post_error'] = "Failed to archive post.";
    }

    header('Location: ' . BASE_PATH . 'index.php?page=users-profile');
    exit;
} 
else {
    $_SESSION['delete_post_error'] = "Invalid request method.";
    header('Location: ' . BASE_PATH . 'index.php?page=users-profile');
    exit;
}
