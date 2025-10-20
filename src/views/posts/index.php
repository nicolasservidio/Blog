<?php
require_once __DIR__ . '/../../../config/constants.php';
require_once __DIR__ . '/../../../config/conn.php';
require_once __DIR__ . '/../../controllers/PostController.php';

if (!defined('BASE_PATH')) {
    exit('Direct access not allowed.');
}

$pageTitle = 'All Posts';
$conn = connectDB();

// Retrieve all posts
$posts = PostController::index($conn);

// Start output buffering
ob_start();
?>

<section class="section section-light fade-in">
    <div class="container" id="main-content">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">📚 All Posts</h2>
            <?php if (isset($_SESSION['user'])): ?>
                <a href="<?= BASE_PATH ?>index.php?page=post-create" class="btn btn-custom">➕ Create Post</a>
            <?php endif; ?>
        </div>

        <?php if (!empty($posts)): ?>
            <div class="row row-cols-1 row-cols-md-2 g-4">
                
                <?php foreach ($posts as $post): ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm">

                            <?php if (!empty($post['featured_image'])): ?> 
                                <img src="<?= htmlspecialchars($post['featured_image']) ?>" class="card-img-top" alt="Featured image for <?= htmlspecialchars($post['title']) ?>">
                            <?php endif; ?>

                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($post['excerpt']) ?></p>
                                <a href="<?= BASE_PATH ?>index.php?page=post-show&id=<?= $post['id'] ?>" class="btn btn-outline-primary">Read More</a>
                            </div>
                            <div class="card-footer text-muted small">
                                Status: <?= htmlspecialchars($post['status']) ?> |
                                Created: <?= date('M d, Y', strtotime($post['created_at'])) ?>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                No posts found. You can create one using the button above.
            </div>
        <?php endif; ?>

    </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout/main.php';