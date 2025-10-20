<?php
require_once __DIR__ . '/../../../config/constants.php';
require_once __DIR__ . '/../../../config/conn.php';
require_once __DIR__ . '/../../controllers/PostController.php';

if (!defined('BASE_PATH')) {
    exit('Direct access not allowed.');
}

$pageTitle = 'Create Post';
$conn = connectDB();

// Retrieve authors and categories
$data = PostController::create($conn);
$authors = $data['authors'] ?? [];
$categories = $data['categories'] ?? [];

// Alert messages
$errorMessage = $_SESSION['post_error'] ?? '';
unset($_SESSION['post_error']);

// Start output buffering
ob_start();
?>

<section class="section section-light fade-in">
    <div class="container" id="main-content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-custom">
                    <div class="card-header text-center">
                        <h2 class="mb-0">📝 Create New Post</h2>
                    </div>

                    <div class="card-body">
                        <?php if (!empty($errorMessage)): ?>
                            <div class="alert-custom alert-error">
                                <?= htmlspecialchars($errorMessage) ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= BASE_PATH ?>index.php?page=post-create-action" method="POST" class="form-accessible">
                            <div class="form-group">
                                <label for="title" class="form-label accessible-label">Title</label>
                                <input type="text" id="title" name="title" required placeholder="Post title"
                                       value="<?= htmlspecialchars($_SESSION['post_title'] ?? '') ?>">
                            </div>

                            <div class="form-group">
                                <label for="slug" class="form-label accessible-label">Slug</label>
                                <input type="text" id="slug" name="slug" required placeholder="post-title-slug"
                                       value="<?= htmlspecialchars($_SESSION['post_slug'] ?? '') ?>">
                            </div>

                            <div class="form-group">
                                <label for="excerpt" class="form-label accessible-label">Excerpt</label>
                                <textarea id="excerpt" name="excerpt" rows="2" placeholder="Short summary"><?= htmlspecialchars($_SESSION['post_excerpt'] ?? '') ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="content" class="form-label accessible-label">Content</label>
                                <textarea id="content" name="content" rows="6" required placeholder="Full post content"><?= htmlspecialchars($_SESSION['post_content'] ?? '') ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="featured_image" class="form-label accessible-label">Featured Image URL</label>
                                <input type="text" id="featured_image" name="featured_image" placeholder="https://example.com/image.jpg"
                                       value="<?= htmlspecialchars($_SESSION['post_featured_image'] ?? '') ?>">
                            </div>

                            <!-- Author -->
                            <?php
                            $loggedInUserId = $_SESSION['user']['id'] ?? null;
                            $loggedInUserName = $_SESSION['user']['name'] ?? 'Unknown';
                            ?>
                            <div class="form-group">
                                <label class="form-label accessible-label">Author</label>
                                <input type="hidden" name="author_id" value="<?= $loggedInUserId ?>">
                                <p class="form-control-plaintext">👤 <?= htmlspecialchars($loggedInUserName) ?></p>
                            </div>

                            <div class="form-group">
                                <label for="category_id" class="form-label accessible-label">Category</label>
                                <select id="category_id" name="category_id">
                                    <option value="">Select category</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>"
                                            <?= (isset($_SESSION['post_category_id']) && $_SESSION['post_category_id'] == $category['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($category['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="meta_title" class="form-label accessible-label">Meta Title</label>
                                <input type="text" id="meta_title" name="meta_title" placeholder="SEO title"
                                       value="<?= htmlspecialchars($_SESSION['post_meta_title'] ?? '') ?>">
                            </div>

                            <div class="form-group">
                                <label for="meta_description" class="form-label accessible-label">Meta Description</label>
                                <textarea id="meta_description" name="meta_description" rows="2" placeholder="SEO description"><?= htmlspecialchars($_SESSION['post_meta_description'] ?? '') ?></textarea>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-custom">Publish Draft</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
unset($_SESSION['post_title'], $_SESSION['post_slug'], $_SESSION['post_excerpt'], $_SESSION['post_content'], $_SESSION['post_featured_image'], $_SESSION['post_author_id'], $_SESSION['post_category_id'], $_SESSION['post_meta_title'], $_SESSION['post_meta_description']);
$content = ob_get_clean();
include __DIR__ . '/../layout/main.php';