<?php

require_once __DIR__ . '/../../../config/constants.php';

if (basename($_SERVER['SCRIPT_FILENAME']) === basename(__FILE__)) {  // This automatically redirects if someone accesses the file directly.
    header('Location: ' . BASE_PATH . 'index.php?page=users-login');
    exit;
}

// Optional: set page title for <title> tag in main.php
$pageTitle = 'Login';

// Start output buffering to capture content
ob_start();
?>

<section class="section section-light fade-in">
    <div class="container" id="main-content">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card-custom">
                    <div class="card-header text-center">
                        <h2 class="mb-0">Login</h2>
                    </div>
                    <div class="card-body">
                        <!-- Alert placeholder -->
                        <?php if (!empty($_SESSION['login_error'])): ?>
                            <div class="alert-custom alert-error">
                                <?= htmlspecialchars($_SESSION['login_error']) ?>
                                <?= htmlspecialchars($_SESSION['login_validations'] ?? '') ?>
                            </div>
                            <?php
                                unset($_SESSION['login_error']);
                                unset($_SESSION['login_validations']);
                            ?>
                        <?php endif; ?>

                        <form action="<?= BASE_PATH ?>index.php?page=login-action" method="POST" class="form-accessible" data-autosave="login-form">

                            <div class="form-group">
                                <label for="email" class="form-label accessible-label">Email address</label>
                                <input type="email" id="email" name="email" placeholder="you@example.com" required
                                        value="<?= isset($_SESSION['login_email']) ? htmlspecialchars($_SESSION['login_email']) : (isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '') ?>">
                                <div class="form-error"></div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="form-label accessible-label">Password</label>
                                <input type="password" id="password" name="password" placeholder="••••••••" required>
                                <div class="form-error"></div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-custom">Login</button>
                            </div>
                        </form>

                        <div class="mt-3 text-center">
                            <p class="text-touch-muted">Don't have an account?
                                <a href="<?= BASE_PATH ?>index.php?page=users-register">Sign up here</a>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php unset($_SESSION['login_email']); ?>

<?php
// Capture content and inject into layout
$content = ob_get_clean();
include __DIR__ . '/../layout/main.php';