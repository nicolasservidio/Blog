<?php
$content = ob_get_clean();
ob_start();
?>

<div class="hero-section bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold">Welcome to Our Blog</h1>
                <p class="lead">Discover amazing stories, insights, and knowledge shared by our community of writers.</p>
                <a href="/blog" class="btn btn-light btn-lg">Explore Blog</a>
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-blog" style="font-size: 8rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <!-- Featured Posts -->
    <section class="mb-5">
        <h2 class="text-center mb-4">Latest Posts</h2>
        <div class="row">
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <?php if ($post['featured_image']): ?>
                                <img src="<?= htmlspecialchars($post['featured_image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($post['title']) ?>" style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fas fa-image text-muted" style="font-size: 3rem;"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
                                <p class="card-text text-muted"><?= htmlspecialchars($post['excerpt'] ?? substr(strip_tags($post['content']), 0, 100) . '...') ?></p>
                                
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <small class="text-muted">
                                            <i class="fas fa-user"></i> <?= htmlspecialchars($post['author_name']) ?>
                                        </small>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar"></i> <?= date('M j, Y', strtotime($post['created_at'])) ?>
                                        </small>
                                    </div>
                                    
                                    <?php if ($post['category_name']): ?>
                                        <span class="badge bg-primary mb-2"><?= htmlspecialchars($post['category_name']) ?></span>
                                    <?php endif; ?>
                                    
                                    <a href="/blog/<?= htmlspecialchars($post['slug']) ?>" class="btn btn-outline-primary btn-sm">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <div class="py-5">
                        <i class="fas fa-newspaper text-muted" style="font-size: 4rem;"></i>
                        <h4 class="text-muted mt-3">No posts yet</h4>
                        <p class="text-muted">Check back later for new content!</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <?php if (!empty($posts)): ?>
            <div class="text-center mt-4">
                <a href="/blog" class="btn btn-primary">View All Posts</a>
            </div>
        <?php endif; ?>
    </section>

    <!-- Categories -->
    <?php if (!empty($categories)): ?>
        <section class="mb-5">
            <h2 class="text-center mb-4">Categories</h2>
            <div class="row">
                <?php foreach ($categories as $category): ?>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="mb-2">
                                    <i class="fas fa-folder" style="color: <?= htmlspecialchars($category['color']) ?>; font-size: 2rem;"></i>
                                </div>
                                <h5 class="card-title"><?= htmlspecialchars($category['name']) ?></h5>
                                <p class="card-text text-muted"><?= htmlspecialchars($category['description']) ?></p>
                                <span class="badge bg-secondary"><?= $category['post_count'] ?> posts</span>
                                <br>
                                <a href="/category/<?= htmlspecialchars($category['slug']) ?>" class="btn btn-outline-primary btn-sm mt-2">View Posts</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/app.php';
?>
