<?php
$content = ob_get_clean();
ob_start();
?>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-8">
            <article class="card shadow-sm">
                <?php if ($post['featured_image']): ?>
                    <img src="<?= htmlspecialchars($post['featured_image']) ?>" 
                         class="card-img-top" 
                         alt="<?= htmlspecialchars($post['title']) ?>"
                         style="height: 400px; object-fit: cover;">
                <?php endif; ?>
                
                <div class="card-body">
                    <header class="mb-4">
                        <h1 class="card-title h2"><?= htmlspecialchars($post['title']) ?></h1>
                        
                        <div class="post-meta mb-3">
                            <div class="d-flex flex-wrap align-items-center text-muted">
                                <span class="me-3">
                                    <i class="fas fa-user"></i> <?= htmlspecialchars($post['author_name']) ?>
                                </span>
                                <span class="me-3">
                                    <i class="fas fa-calendar"></i> <?= date('F j, Y', strtotime($post['created_at'])) ?>
                                </span>
                                <?php if ($post['category_name']): ?>
                                    <span class="me-3">
                                        <i class="fas fa-folder"></i> 
                                        <a href="/category/<?= htmlspecialchars($post['category_slug'] ?? '') ?>" 
                                           class="text-decoration-none">
                                            <?= htmlspecialchars($post['category_name']) ?>
                                        </a>
                                    </span>
                                <?php endif; ?>
                                <span>
                                    <i class="fas fa-clock"></i> <?= ceil(str_word_count(strip_tags($post['content'])) / 200) ?> min read
                                </span>
                            </div>
                        </div>
                    </header>
                    
                    <div class="post-content">
                        <?= nl2br(htmlspecialchars($post['content'])) ?>
                    </div>
                    
                    <?php if ($post['excerpt']): ?>
                        <div class="mt-4 p-3 bg-light rounded">
                            <h6 class="text-muted mb-2">Summary</h6>
                            <p class="mb-0"><?= htmlspecialchars($post['excerpt']) ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </article>
            
            <!-- Related Posts -->
            <?php if (!empty($related_posts)): ?>
                <section class="mt-5">
                    <h3 class="mb-4">Related Posts</h3>
                    <div class="row">
                        <?php foreach ($related_posts as $related): ?>
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <?php if ($related['featured_image']): ?>
                                        <img src="<?= htmlspecialchars($related['featured_image']) ?>" 
                                             class="card-img-top" 
                                             alt="<?= htmlspecialchars($related['title']) ?>"
                                             style="height: 150px; object-fit: cover;">
                                    <?php endif; ?>
                                    
                                    <div class="card-body d-flex flex-column">
                                        <h6 class="card-title">
                                            <a href="/blog/<?= htmlspecialchars($related['slug']) ?>" 
                                               class="text-decoration-none text-dark">
                                                <?= htmlspecialchars($related['title']) ?>
                                            </a>
                                        </h6>
                                        
                                        <p class="card-text text-muted small flex-grow-1">
                                            <?= htmlspecialchars(substr(strip_tags($related['content']), 0, 100) . '...') ?>
                                        </p>
                                        
                                        <div class="mt-auto">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar"></i> <?= date('M j, Y', strtotime($related['created_at'])) ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">About the Author</h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-user-circle text-primary" style="font-size: 4rem;"></i>
                    </div>
                    <h6><?= htmlspecialchars($post['author_name']) ?></h6>
                    <p class="text-muted small">Blog Author</p>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Share this post</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="https://twitter.com/intent/tweet?text=<?= urlencode($post['title']) ?>&url=<?= urlencode($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>" 
                           target="_blank" 
                           class="btn btn-outline-primary btn-sm">
                            <i class="fab fa-twitter"></i> Share on Twitter
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>" 
                           target="_blank" 
                           class="btn btn-outline-primary btn-sm">
                            <i class="fab fa-facebook"></i> Share on Facebook
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>" 
                           target="_blank" 
                           class="btn btn-outline-primary btn-sm">
                            <i class="fab fa-linkedin"></i> Share on LinkedIn
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/app.php';
?>
