<?php

require_once __DIR__ . '/../../../config/constants.php';

if (basename($_SERVER['SCRIPT_FILENAME']) === basename(__FILE__)) {  // This automatically redirects if someone accesses the file directly.
    header('Location: ' . BASE_PATH . 'index.php?page=users-profile');
    exit;
}

$pageTitle = 'Your Profile';
ob_start();

// Check session
if (!isset($_SESSION['user']) || !is_array($_SESSION['user'])) {
    echo '<div class="alert-custom alert-error text-center">You must be logged in to view this page.</div>';
    $content = ob_get_clean();
    include __DIR__ . '/../layout/main.php';
    return;
}

$user = $_SESSION['user'];

// Getting all the blog posts by the logged-in author
require_once __DIR__ . '/../../../config/conn.php';
$conn = connectDB();

require_once __DIR__ . '/../../controllers/PostController.php';

$statusFilter = $_GET['status'] ?? null; // for classification of posts by status
$userPosts = PostController::getByAuthorAndStatus($conn, $user['id'], $statusFilter); // Getting blog posts and status of each one
$postCount = count($userPosts);

?>

<section class="section section-light fade-in">
    <div class="container" id="main-content">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <!-- Profile card of the user -->
                <div class="card-custom">
                    <div class="card-header text-center">
                        <h2 class="mb-0">Welcome, <?= htmlspecialchars($user['name']) ?></h2>
                        <p class="text-muted small">Role: <?= htmlspecialchars($user['role']) ?></p>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></li>
                            <li class="list-group-item"><strong>Status:</strong> <?= htmlspecialchars($user['status']) ?></li>
                            <li class="list-group-item"><strongJoined:</strong> <?= htmlspecialchars($user['created_at']) ?></li>
                            <li class="list-group-item"><strongLast Updated:</strong> <?= htmlspecialchars($user['updated_at']) ?></li>
                            <?php if (!empty($user['bio'])): ?>
                                <li class="list-group-item"><strong>Bio:</strong> <?= htmlspecialchars($user['bio']) ?></li>
                            <?php endif; ?>
                        </ul>

                        <div class="mt-4 text-center">
                            <a href="<?= BASE_PATH ?>index.php?page=users-logout" class="btn btn-outline-danger">Sign Out</a>
                        </div>
                    </div>
                </div>

                <!-- Author posts -->
                <?php if (!empty($userPosts)): ?>
                    <section class="mt-5">
                        
                        <h3 class="text-center">📝 Your Posts (<?= $postCount ?>)</h3>

                        <form method="GET" action="<?= BASE_PATH ?>index.php" class="text-center mb-3">
                            <input type="hidden" name="page" value="users-profile">
                            <label for="status" class="form-label">Filter by status:</label>
                            <select name="status" id="status" onchange="this.form.submit()" class="form-select w-auto d-inline-block">
                                <option value="" <?= ($statusFilter === null || $statusFilter === '') ? 'selected' : '' ?>>All (except archived)</option>
                                <option value="draft" <?= ($statusFilter === 'draft') ? 'selected' : '' ?>>Draft</option>
                                <option value="published" <?= ($statusFilter === 'published') ? 'selected' : '' ?>>Published</option>
                                <option value="archived" <?= ($statusFilter === 'archived') ? 'selected' : '' ?>>Archived</option>
                            </select>
                        </form>
                        
                        <ul class="list-group list-group-flush">
                            <?php foreach ($userPosts as $post): ?>
                                <li class="list-group-item">
                                    <a href="<?= BASE_PATH ?>index.php?page=post-show&id=<?= $post['id'] ?>">
                                        <?= htmlspecialchars($post['title']) ?>
                                    </a> <br>
                                    <span class="badge bg-secondary"><?= htmlspecialchars($post['status']) ?></span>
                                    <small class="text-muted float-end">Created at: <?= htmlspecialchars($post['created_at']) ?></small>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </section>
                <?php else: ?>
                    <p class="text-center mt-4 text-muted">No posts found for this filter.</p>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout/main.php';