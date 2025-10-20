<?php

require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/../../config/conn.php';
require_once __DIR__ . '/../controllers/PostController.php';

if (!defined('BASE_PATH')) {
    exit('Direct access not allowed.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = connectDB();

    // Sanitize input
    $title            = trim(strip_tags($_POST['title'] ?? ''));
    $slug             = trim(strip_tags($_POST['slug'] ?? ''));
    $excerpt          = trim(strip_tags($_POST['excerpt'] ?? ''));
    $content          = trim(strip_tags($_POST['content'] ?? ''));
    $featured_image   = trim(strip_tags($_POST['featured_image'] ?? ''));
    $author_id        = $_SESSION['user']['id'] ?? null;
    $category_id      = $_POST['category_id'] ?? null;
    $meta_title       = trim(strip_tags($_POST['meta_title'] ?? ''));
    $meta_description = trim(strip_tags($_POST['meta_description'] ?? ''));

    // Preserve input in session
    $_SESSION['post_title']            = $title;
    $_SESSION['post_slug']             = $slug;
    $_SESSION['post_excerpt']          = $excerpt;
    $_SESSION['post_content']          = $content;
    $_SESSION['post_featured_image']   = $featured_image;
    $_SESSION['post_category_id']      = $category_id;
    $_SESSION['post_meta_title']       = $meta_title;
    $_SESSION['post_meta_description'] = $meta_description;

    // Basic validation
    if (empty($title) || empty($slug) || empty($content) || !$author_id) {
        $_SESSION['post_error'] = "Title, slug, and content are required.";
        header('Location: ' . BASE_PATH . 'index.php?page=post-create');
        exit;
    }

    // Store post
    $success = PostController::store(
        $conn,
        $title,
        $slug,
        $content,
        $excerpt,
        $featured_image,
        $author_id,
        $category_id,
        $meta_title,
        $meta_description
    );

    if ($success) {
        // Clear session data
        unset(
            $_SESSION['post_title'],
            $_SESSION['post_slug'],
            $_SESSION['post_excerpt'],
            $_SESSION['post_content'],
            $_SESSION['post_featured_image'],
            $_SESSION['post_category_id'],
            $_SESSION['post_meta_title'],
            $_SESSION['post_meta_description'],
            $_SESSION['post_error']
        );

        // Redirect to post index
        header('Location: ' . BASE_PATH . 'index.php?page=post-index');
        exit;
    } 
    else {
        $_SESSION['post_error'] = "Failed to create post. Please try again.";
        header('Location: ' . BASE_PATH . 'index.php?page=post-create');
        exit;
    }
} 
else {
    // Invalid access
    $_SESSION['post_error'] = "Invalid request method.";
    header('Location: ' . BASE_PATH . 'index.php?page=post-create');
    exit;
}