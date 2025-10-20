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
    $id               = intval($_POST['id'] ?? 0);
    $title            = trim(htmlspecialchars($_POST['titlepost'] ?? '', ENT_QUOTES, 'UTF-8'));
    $slug             = trim(htmlspecialchars($_POST['slug'] ?? '', ENT_QUOTES, 'UTF-8'));
    $excerpt          = trim(strip_tags($_POST['excerpt'] ?? ''));
    $content          = trim(strip_tags($_POST['content'] ?? ''));
    $featured_image   = trim($_POST['featured_image'] ?? '');
    $category_id      = isset($_POST['category_id']) && is_numeric($_POST['category_id'])
                        ? intval($_POST['category_id'])
                        : 0; // fallback to 0 or handle as invalid
    $meta_title       = trim(htmlspecialchars($_POST['meta_title'] ?? '', ENT_QUOTES, 'UTF-8'));
    $meta_description = trim(htmlspecialchars($_POST['meta_description'] ?? '', ENT_QUOTES, 'UTF-8'));
    $status           = $_POST['status'] ?? '';

    // Preserve input in session
    $_SESSION['edit_post_id']               = $id;
    $_SESSION['edit_post_title']            = $title;
    $_SESSION['edit_post_slug']             = $slug;
    $_SESSION['edit_post_excerpt']          = $excerpt;
    $_SESSION['edit_post_content']          = $content;
    $_SESSION['edit_post_featured_image']   = $featured_image;
    $_SESSION['edit_post_category_id']      = $category_id;
    $_SESSION['edit_post_meta_title']       = $meta_title;
    $_SESSION['edit_post_meta_description'] = $meta_description;
    $_SESSION['edit_post_status']           = $status;

    // Basic validation
    if (empty($id) || empty($title) || empty($slug) || empty($content)) {
        $_SESSION['edit_post_error'] = "Title, slug, and content are required.";
        header('Location: ' . BASE_PATH . 'index.php?page=post-edit&id=' . $id);
        exit;
    }

    // Access control
    $original = PostController::edit($conn, $id);
    $post = $original['post'] ?? null;

    $isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    $isAuthor = isset($_SESSION['user']) && $_SESSION['user']['id'] == ($post['author_id'] ?? null);

    if (!$post || (!$isAdmin && !$isAuthor)) {
        $_SESSION['edit_post_error'] = "Unauthorized update attempt.";
        header('Location: ' . BASE_PATH . 'index.php?page=post-edit&id=' . $id);
        exit;
    }

    // Update post
    $success = PostController::update(
        $conn,
        $id,
        $title,
        $slug,
        $content,
        $excerpt,
        $featured_image,
        $category_id,
        $meta_title,
        $meta_description,
        $status
    );

    if ($success) {
        // Clear session data
        unset(
            $_SESSION['edit_post_id'],
            $_SESSION['edit_post_title'],
            $_SESSION['edit_post_slug'],
            $_SESSION['edit_post_excerpt'],
            $_SESSION['edit_post_content'],
            $_SESSION['edit_post_featured_image'],
            $_SESSION['edit_post_category_id'],
            $_SESSION['edit_post_meta_title'],
            $_SESSION['edit_post_meta_description'],
            $_SESSION['edit_post_status'],
            $_SESSION['edit_post_error']
        );

        // Redirect to post-show
        header('Location: ' . BASE_PATH . 'index.php?page=post-show&id=' . $id );
        exit;
    } 
    else {
        $_SESSION['edit_post_error'] = "Failed to update post. Please try again.";
        header('Location: ' . BASE_PATH . 'index.php?page=post-edit&id=' . $id);
        exit;
    }
} 
else {
    $_SESSION['edit_post_error'] = "Invalid request method.";
    header('Location: ' . BASE_PATH . 'index.php?page=post-index');
    exit;
}