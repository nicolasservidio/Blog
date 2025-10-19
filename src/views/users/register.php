<?php

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
                        <?php if (!empty($errorMessage)): ?>
                            <div class="alert-custom alert-error">
                                <?= htmlspecialchars($errorMessage) ?>
                            </div>
                        <?php endif; ?>

                        <form action="/src/controllers/UserController.php" method="POST" class="form-accessible" data-autosave="register-form">
                            <input type="hidden" name="action" value="register">

                            <div class="form-group">
                                <label for="username" class="form-label accessible-label">Username</label>
                                <input type="text" id="username" name="username" required placeholder="Your username">
                                <div class="form-error"></div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label accessible-label">Email address</label>
                                <input type="email" id="email" name="email" required placeholder="you@example.com">
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
                                <a href="login.php">Login here</a>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout/main.php';