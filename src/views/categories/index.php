<?php

require_once __DIR__ . '/../../../config/constants.php';
require_once __DIR__ . '/../../../config/conn.php';
require_once __DIR__ . '/../../controllers/CategoryController.php';

if (!defined('BASE_PATH')) {
    exit('Direct access not allowed.');
}

$pageTitle = 'Categories';
$conn = connectDB();
$categories = CategoryController::index($conn);

// Start output buffering
ob_start();
?>

<section class="section section-light fade-in">
    <div class="container" id="main-content">

        <?php if (isset($_SESSION['category_success'])): ?>
            <div class="alert alert-success text-center"><?= htmlspecialchars($_SESSION['category_success']) ?></div>
            <?php unset($_SESSION['category_success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['category_error'])): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($_SESSION['category_error']); ?></div>
            <?php unset($_SESSION['category_error']); ?>
        <?php endif; ?>

        <h2 class="text-center mb-4">📚 Blog Categories</h2>

        <?php if (!empty($categories)): ?>
            <div class="row">
                
                <?php foreach ($categories as $category): ?>
                    <?php if ($category['status'] === 'active'): ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header text-white" style="background-color: <?= htmlspecialchars($category['color']) ?>;">
                                    <h5 class="mb-0"><?= htmlspecialchars($category['name']) ?></h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text"><?= htmlspecialchars($category['description']) ?></p>
                                </div>
                                <div class="card-footer text-end">
                                    <a href="<?= BASE_PATH ?>index.php?page=categories-show&slug=<?= urlencode($category['slug']) ?>" class="btn btn-sm btn-outline-primary">View Posts</a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'Sr Administrator'): ?>
            <div class="text-center mt-4">
                <br><br>
                <a href="<?= BASE_PATH ?>index.php?page=categories-create" class="btn btn-outline-success">➕ Create New Category</a>
            </div>
        <?php endif; ?>

        <?php else: ?>
            <div class="alert alert-info text-center">No categories found.</div>
        <?php endif; ?>
    </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout/main.php';