<?php

require_once __DIR__ . '/../../../config/constants.php';

if (basename($_SERVER['SCRIPT_FILENAME']) === basename(__FILE__)) {  // This automatically redirects if someone accesses the file directly.
    header('Location: ' . BASE_PATH . 'index.php?page=users-register');
    exit;
}

$pageTitle = 'Sign Up';

ob_start();
?>

<section class="section section-light fade-in">
    <div class="container" id="main-content">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card-custom">
                    <div class="card-header text-center">
                        <h2 class="mb-0">Create Account</h2>
                    </div>

                    <div class="card-body">
                        <!-- Alert placeholder -->
                        <?php if (!empty($_SESSION['signup_error'])): ?>
                            <div class="alert-custom alert-error">
                                <?= htmlspecialchars($_SESSION['signup_error']) ?>
                                <?= htmlspecialchars($_SESSION['signup_validations'] ?? '') ?>
                            </div>
                            <?php
                                unset($_SESSION['signup_error']);
                                unset($_SESSION['signup_validations']);
                            ?>
                        <?php endif; ?>

                        <form action="<?= BASE_PATH ?>index.php?page=register-action" method="POST" class="form-accessible" data-autosave="register-form">
                            <div class="form-group">
                                <label for="name" class="form-label accessible-label">Full Name</label>
                                <input type="text" id="name" name="name" required placeholder="Your full name"
                                       value="<?= isset($_SESSION['signup_name']) ? htmlspecialchars($_SESSION['signup_name']) : (isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '') ?>">
                                <div class="form-error"></div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label accessible-label">Email address</label>
                                <input type="email" id="email" name="email" required placeholder="you@example.com"
                                       value="<?= isset($_SESSION['signup_email']) ? htmlspecialchars($_SESSION['signup_email']) : (isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '') ?>">
                                <div class="form-error"></div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="form-label accessible-label">Password</label>
                                <input type="password" id="password" name="password" required placeholder="••••••••">
                                <div class="form-error"></div>
                            </div>

                            <div class="form-group">
                                <label for="confirm_password" class="form-label accessible-label">Confirm Password</label>
                                <input type="password" id="confirm_password" name="confirm_password" required placeholder="••••••••">
                                <div class="form-error"></div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-custom">Sign Up</button>
                            </div>
                        </form>

                        <div class="mt-3 text-center">
                            <p class="text-touch-muted">Already have an account?
                                <a href="<?= BASE_PATH ?>index.php?page=users-login">Login here</a>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php unset($_SESSION['signup_name']); ?>
<?php unset($_SESSION['signup_email']); ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout/main.php';