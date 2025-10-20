<?php

require_once __DIR__ . '/../../../config/constants.php';

if (!defined('BASE_PATH')) {
    exit('Direct access not allowed.');
}

$pageTitle = 'Create Category';

// Access control
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Sr Administrator') {
    ob_start();
    echo '<div class="alert alert-danger text-center">Access denied. Only administrators can create categories.</div>';
    $content = ob_get_clean();
    include __DIR__ . '/../layout/main.php';
    return;
}

// Start output buffering
ob_start();
?>

<section class="section section-light fade-in">
    <div class="container" id="main-content">
        <h2 class="text-center mb-4">➕ Create New Category</h2>

        <form action="<?= BASE_PATH ?>index.php?page=categories-store-action" method="POST" class="card card-body shadow-sm">
            <div class="mb-3">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" name="name" id="name" class="form-control" required maxlength="255">
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label">Slug (URL identifier)</label>
                <input type="text" name="slug" id="slug" class="form-control" required maxlength="255">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success">✅ Create Category</button>
                <a href="<?= BASE_PATH ?>index.php?page=categories-index" class="btn btn-outline-secondary ms-2">← Cancel</a>
            </div>
        </form>
    </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout/main.php';