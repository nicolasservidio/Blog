<?php

require_once __DIR__ . '/../../../config/constants.php';
require_once __DIR__ . '/../../../config/conn.php';
require_once __DIR__ . '/../../controllers/PostController.php';

if (!defined('BASE_PATH')) {
    exit('Direct access not allowed.');
}

$pageTitle = isset($post['title']) ? $post['title'] : 'Post Details';
$conn = connectDB();

// Validate and retrieve post ID
$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$data = $id ? PostController::edit($conn, $id) : null;
$post = $data['post'] ?? null;

// Start output buffering
ob_start();
?>

<section class="section section-light fade-in">
    <div class="container" id="main-content">

        <?php if ($post): ?>
            <article class="card-custom mb-4">
                <div class="card-header">
                    <h2><?= htmlspecialchars($post['title']) ?></h2>
                    <p class="text-muted small">
                        Status: <?= htmlspecialchars($post['status']) ?> |
                        Created: <?= date('M d, Y', strtotime($post['created_at'])) ?>
                    </p>
                </div>

                <?php if (!empty($post['featured_image'])): ?>
                    <img src="<?= htmlspecialchars($post['featured_image']) ?>" alt="Featured image" class="img-fluid mb-3 rounded">
                <?php endif; ?>

                <div class="card-body">
                    <?php if (!empty($post['excerpt'])): ?>
                        <p class="lead"><?= htmlspecialchars($post['excerpt']) ?></p>
                    <?php endif; ?>

                    <div class="post-content">
                        <?= nl2br(htmlspecialchars($post['content'])) ?>
                    </div>
                </div>

                <div class="card-footer text-muted small">
                    Category: <?= htmlspecialchars($post['category_name']) ?> |
                    Author: <?= htmlspecialchars($post['author_name']) ?>
                </div>
            </article>

            <div class="text-center">
                <a href="<?= BASE_PATH ?>index.php?page=post-index" class="btn btn-outline-secondary">← Back to Posts</a>
            </div>

        <?php else: ?>
            <div class="alert alert-danger text-center">
                Post not found or invalid ID.
            </div>
        <?php endif; ?>

    </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout/main.php';