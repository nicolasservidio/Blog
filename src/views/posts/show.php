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

require_once __DIR__ . '/../../utils/Parsedown.php';  // Enable Markdown Rendering with "Parsedown" (https://github.com/erusev/parsedown)
$Parsedown = new Parsedown();

// Start output buffering
ob_start();
?>

<section class="section section-light fade-in">
    <div class="container" id="main-content">

        <?php if ($post): ?>

            <!-- success/error messags for deletion -->
            <?php if (isset($_SESSION['delete_post_success'])): ?>
                <div class="alert alert-success text-center"><?= htmlspecialchars($_SESSION['delete_post_success']) ?></div>
                <?php unset($_SESSION['delete_post_success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['delete_post_error'])): ?>
                <div class="alert alert-danger text-center"><?= htmlspecialchars($_SESSION['delete_post_error']) ?></div>
                <?php unset($_SESSION['delete_post_error']); ?>
            <?php endif; ?>

            <!-- Blog post -->
            <article class="card-custom mb-4">
                <div class="card-header">
                    <h2><?= htmlspecialchars($post['title']) ?></h2>
                    <p class="text-muted small">
                        Status: <?= htmlspecialchars($post['status']) ?> |
                        Created: <?= date('M d, Y', strtotime($post['created_at'])) ?>
                    </p>
                </div>

                <?php if (!empty($post['featured_image'])): ?>
                    <a href="<?= htmlspecialchars($post['featured_image']) ?>" target="_blank">
                        <img src="<?= htmlspecialchars($post['featured_image']) ?>" alt="Featured image" class="img-fluid mb-3 rounded shadow-sm">
                    </a>
                <?php endif; ?>

                <div class="card-body">
                    <?php if (!empty($post['excerpt'])): ?>
                        <p class="lead"><?= htmlspecialchars($post['excerpt']) ?></p>
                    <?php endif; ?>

                    <div class="post-content">
                        <?php // nl2br(htmlspecialchars($post['content'])); ?> <!-- This is default, now using "Parsedown" -->
                        <?= $Parsedown->text($post['content']) ?>
                    </div>
                </div>

                <div class="card-footer text-muted small">
                    Category: <?= htmlspecialchars($post['category_name']) ?> |
                    Author: <?= htmlspecialchars($post['author_name']) ?>
                </div>

                <!-- Edit and delete buttons for author and admin only -->
                <?php
                $isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
                $isAuthor = isset($_SESSION['user']) && $_SESSION['user']['id'] == $post['author_id'];
                ?>

                <?php if ($isAdmin || $isAuthor): ?>
                    <div class="text-end mt-3">
                        
                        <a href="<?= BASE_PATH ?>index.php?page=post-edit&id=<?= $post['id'] ?>" class="btn btn-outline-primary me-2">✏️ Edit</a>

                        <form action="<?= BASE_PATH ?>index.php?page=post-delete-action" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to archive this post?');">                            
                            <button type="submit" class="btn btn-outline-danger">🗑️ Archive</button>
                            <input type="hidden" name="id" value="<?= $post['id'] ?>">
                        </form>
                    </div>
                <?php endif; ?>
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