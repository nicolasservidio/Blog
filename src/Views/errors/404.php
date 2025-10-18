<?php
$content = ob_get_clean();
ob_start();
?>

<div class="container">
    <div class="error-page">
        <div class="text-center">
            <div class="error-code">404</div>
            <h1 class="h3 mb-3">Page Not Found</h1>
            <p class="text-muted mb-4">The page you're looking for doesn't exist or has been moved.</p>
            <a href="/" class="btn btn-primary">
                <i class="fas fa-home"></i> Go Home
            </a>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/app.php';
?>
