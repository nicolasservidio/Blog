<?php

require_once __DIR__ . '/../../../config/constants.php';

?>

<footer class="footer mt-auto py-3 bg-light border-top">
    <div class="container text-center small text-muted">
        <span>&copy; <?= date('Y') ?> MyBlog. All rights reserved.</span>
        <span class="mx-2">|</span>
        <a href="<?= BASE_PATH ?>index.php" class="text-decoration-none">Home</a>
        <span class="mx-2">|</span>
        <a href="<?= BASE_PATH ?>index.php?page=post-index" class="text-decoration-none">Posts</a>
        <span class="mx-2">|</span>
        <a href="<?= BASE_PATH ?>index.php?page=categories-index" class="text-decoration-none">Categories</a>
        <span class="mx-2">|</span>
        <a href="<?= BASE_PATH ?>index.php?page=users-login" class="text-decoration-none">Login</a>
    </div>
</footer>