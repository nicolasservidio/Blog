<?php

require_once __DIR__ . '/../../../config/constants.php';

// Optional: dynamic page title or user session logic
$pageTitle = $pageTitle ?? 'Blog';

$isLoggedIn = isset($_SESSION['user']) && is_array($_SESSION['user']);
$username = $isLoggedIn && isset($_SESSION['user']['name']) 
    ? htmlspecialchars($_SESSION['user']['name']) 
    : null;

?>

<header class="navbar navbar-expand-lg navbar-custom shadow-sm">
    <div class="container flex-space-between">
        <!-- Brand -->
        <a class="navbar-brand" href="<?= BASE_PATH ?>index.php">MyBlog</a>

        <!-- Skip Link for Accessibility -->
        <a href="#main-content" class="skip-link visually-hidden focus-outline">Go to the content</a>

        <!-- Toggler for mobile -->
        <button class="navbar-toggler btn btn-outline" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" 
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            ☰
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_PATH ?>index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_PATH ?>index.php?page=post-index">Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_PATH ?>index.php?page=categories-index">Categories</a>
                </li>
                
                <?php if ($isLoggedIn): ?>
                    <li class="nav-item dropdown-custom">
                        <span class="dropdown-toggle cursor-pointer" tabindex="0" role="button">👤 <?= $username ?></span>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= BASE_PATH ?>index.php?page=users-profile">Profile</a>
                            <a class="dropdown-item" href="#">Sign out</a>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_PATH ?>index.php?page=users-login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_PATH ?>index.php?page=users-register">Sign up</a>
                    </li>
                <?php endif; ?>
                <!-- Theme Toggle -->
                <li class="nav-item">
                    <button id="theme-toggle" class="btn btn-icon" aria-label="Cambiar tema" data-action="toggle-theme">
                        🌓
                    </button>
                </li>
            </ul>
        </div>
    </div>
</header>