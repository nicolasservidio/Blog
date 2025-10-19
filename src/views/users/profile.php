<?php
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
?>

<section class="section section-light fade-in">
    <div class="container" id="main-content">
        <div class="row justify-content-center">
            <div class="col-md-8">
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
                            <a href="../../controllers/UserController.php?action=logout" class="btn btn-outline-danger">Sign Out</a>
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