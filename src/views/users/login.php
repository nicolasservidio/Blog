<?php
/**
 * ============================================================================
 * LOGIN VIEW — login.php
 * For PHP+MySQL MVC projects using Bootstrap
 * Author: Nicolás Servidio
 * ============================================================================
 */

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
                        <?php 
                            require_once __DIR__ . "/../../controllers/LoginController.php";
                        ?>

                        <form action="login.php" method="POST" class="form-accessible" data-autosave="login-form">
                            <input type="hidden" name="action" value="login">

                            <div class="form-group">
                                <label for="email" class="form-label accessible-label">Email address</label>
                                <input type="email" id="email" name="email" required placeholder="you@example.com" 
                                        value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                                <div class="form-error"></div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="form-label accessible-label">Password</label>
                                <input type="password" id="password" name="password" required placeholder="••••••••"
                                        value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>">
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

<?php
// Capture content and inject into layout
$content = ob_get_clean();
include __DIR__ . '/../layout/main.php';