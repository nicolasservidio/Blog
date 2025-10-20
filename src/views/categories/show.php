<?php

require_once __DIR__ . '/../../../config/constants.php';
require_once __DIR__ . '/../../../config/conn.php';
require_once __DIR__ . '/../../controllers/CategoryController.php';
require_once __DIR__ . '/../../controllers/PostController.php';

if (!defined('BASE_PATH')) {
    exit('Direct access not allowed.');
}

$pageTitle = 'Category';
$conn = connectDB();

// Validate slug
$slug = $_GET['slug'] ?? null;
$category = null;
$posts = [];

if ($slug) {
    // Find category by slug
    $categories = CategoryController::index($conn);
    foreach ($categories as $cat) {
        if ($cat['slug'] === $slug && $cat['status'] === 'active') {
            $category = $cat;
            break;
        }
    }

    // Get posts in this category
    if ($category) {
        $allPosts = PostController::index($conn);
        foreach ($allPosts as $post) {
            if ($post['category_id'] == $category['id'] && $post['status'] !== 'archived') {
                $posts[] = $post;
            }
        }
    }
}

// Start output buffering
ob_start();
?>

<section class="section section-light fade-in">
    <div class="container" id="main-content">

        <?php if ($category): ?>
            <div class="text-center mb-4">
                <h2 style="color: <?= htmlspecialchars($category['color']) ?>;">
                    📁 <?= htmlspecialchars($category['name']) ?>
                </h2>
                <p class="text-muted"><?= htmlspecialchars($category['description']) ?></p>
            </div>

            <?php if (!empty($posts)): ?>
                <ul class="list-group list-group-flush">
                    <?php foreach ($posts as $post): ?>
                        <li class="list-group-item">
                            <a href="<?= BASE_PATH ?>index.php?page=post-show&id=<?= $post['id'] ?>">
                                <?= htmlspecialchars($post['title']) ?>
                            </a>
                            <span class="badge bg-secondary"><?= htmlspecialchars($post['status']) ?></span>
                            <small class="text-muted float-end"><?= htmlspecialchars($post['created_at']) ?></small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <div class="alert alert-info text-center">No posts found in this category.</div>
            <?php endif; ?>

        <?php else: ?>
            <div class="alert alert-danger text-center">Category not found or inactive.</div>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="<?= BASE_PATH ?>index.php?page=categories-index" class="btn btn-outline-secondary">← Back to Categories</a>
        </div>

    </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout/main.php';