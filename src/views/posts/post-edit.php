<?php
require_once __DIR__ . '/../../../config/constants.php';
require_once __DIR__ . '/../../../config/conn.php';
require_once __DIR__ . '/../../controllers/PostController.php';

if (!defined('BASE_PATH')) {
    exit('Direct access not allowed.');
}

$pageTitle = 'Edit Post';
$conn = connectDB();

// Validate and retrieve post ID
$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$data = $id ? PostController::edit($conn, $id) : null;
$post = $data['post'] ?? null;
$categories = $data['categories'] ?? [];

if (!$post) {
    echo '<div class="alert alert-danger text-center">Post not found or invalid ID.</div>';
    return;
}

// Access control: only admin or post author
$isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
$isAuthor = isset($_SESSION['user']) && $_SESSION['user']['id'] == $post['author_id'];

if (!$isAdmin && !$isAuthor) {
    echo '<div class="alert alert-danger text-center">Unauthorized access.</div>';
    return;
}

// Start output buffering
ob_start();
?>

<section class="section section-light fade-in">
    <div class="container" id="main-content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-custom">
                    <div class="card-header text-center">
                        <h2 class="mb-0">✏️ Edit Post</h2>
                    </div>

                    <div class="card-body">
                        <form action="<?= BASE_PATH ?>index.php?page=post-update-action" method="POST" class="form-accessible">

                            <div class="form-group">
                                <label for="titlepost" class="form-label accessible-label">Title</label>
                                <input type="text" id="titlepost" name="titlepost" required value="<?= htmlspecialchars($post['title']) ?>">
                            </div>

                            <div class="form-group">
                                <label for="slug" class="form-label accessible-label">Slug</label>
                                <input type="text" id="slug" name="slug" required value="<?= htmlspecialchars($post['slug']) ?>">
                            </div>

                            <div class="form-group">
                                <label for="excerpt" class="form-label accessible-label">Excerpt</label>
                                <textarea id="excerpt" name="excerpt" rows="2"><?= htmlspecialchars($post['excerpt']) ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="content" class="form-label accessible-label">Content</label>
                                <textarea id="content" name="content" rows="6" required><?= htmlspecialchars($post['content']) ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="featured_image" class="form-label accessible-label">Featured Image URL</label>
                                <input type="text" id="featured_image" name="featured_image" value="<?= htmlspecialchars($post['featured_image']) ?>">
                            </div>

                            <div class="form-group">
                                <label for="category_id" class="form-label accessible-label">Category</label>
                                <select id="category_id" name="category_id">

                                    <option value="">Select category</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>" <?= ($post['category_id'] == $category['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($category['name']) ?>
                                        </option>
                                    <?php endforeach; ?>

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="meta_title" class="form-label accessible-label">Meta Title</label>
                                <input type="text" id="meta_title" name="meta_title" value="<?= htmlspecialchars($post['meta_title']) ?>">
                            </div>

                            <div class="form-group">
                                <label for="meta_description" class="form-label accessible-label">Meta Description</label>
                                <textarea id="meta_description" name="meta_description" rows="2"><?= htmlspecialchars($post['meta_description']) ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="status" class="form-label accessible-label">Status</label>
                                <select id="status" name="status" required>
                                    <option value="draft" <?= ($post['status'] === 'draft') ? 'selected' : '' ?>>Draft</option>
                                    <option value="published" <?= ($post['status'] === 'published') ? 'selected' : '' ?>>Published</option>
                                    <option value="archived" <?= ($post['status'] === 'archived') ? 'selected' : '' ?>>Archived</option>
                                </select>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-custom">💾 Save Changes</button>
                            </div>

                            <input type="hidden" name="id" value="<?= $post['id'] ?>">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout/main.php';