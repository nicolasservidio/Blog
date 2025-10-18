<?php
$content = ob_get_clean();
ob_start();
?>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="mb-4">Blog Posts</h1>
            
            <?php if (!empty($posts['data'])): ?>
                <?php foreach ($posts['data'] as $post): ?>
                    <article class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <div class="row">
                                <?php if ($post['featured_image']): ?>
                                    <div class="col-md-4">
                                        <img src="<?= htmlspecialchars($post['featured_image']) ?>" 
                                             class="img-fluid rounded" 
                                             alt="<?= htmlspecialchars($post['title']) ?>"
                                             style="height: 200px; object-fit: cover; width: 100%;">
                                    </div>
                                    <div class="col-md-8">
                                <?php else: ?>
                                    <div class="col-12">
                                <?php endif; ?>
                                
                                <h2 class="card-title h4">
                                    <a href="/blog/<?= htmlspecialchars($post['slug']) ?>" 
                                       class="text-decoration-none text-dark">
                                        <?= htmlspecialchars($post['title']) ?>
                                    </a>
                                </h2>
                                
                                <p class="card-text text-muted">
                                    <?= htmlspecialchars($post['excerpt'] ?? substr(strip_tags($post['content']), 0, 150) . '...') ?>
                                </p>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="post-meta">
                                        <small class="text-muted">
                                            <i class="fas fa-user"></i> <?= htmlspecialchars($post['author_name']) ?>
                                            <span class="mx-2">•</span>
                                            <i class="fas fa-calendar"></i> <?= date('M j, Y', strtotime($post['created_at'])) ?>
                                            <?php if ($post['category_name']): ?>
                                                <span class="mx-2">•</span>
                                                <i class="fas fa-folder"></i> 
                                                <a href="/category/<?= htmlspecialchars($post['category_slug'] ?? '') ?>" 
                                                   class="text-decoration-none">
                                                    <?= htmlspecialchars($post['category_name']) ?>
                                                </a>
                                            <?php endif; ?>
                                        </small>
                                    </div>
                                    
                                    <a href="/blog/<?= htmlspecialchars($post['slug']) ?>" 
                                       class="btn btn-outline-primary btn-sm">Read More</a>
                                </div>
                                
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
                
                <!-- Pagination -->
                <?php if ($posts['last_page'] > 1): ?>
                    <nav aria-label="Blog pagination">
                        <ul class="pagination justify-content-center">
                            <?php if ($posts['current_page'] > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $posts['current_page'] - 1 ?>">Previous</a>
                                </li>
                            <?php endif; ?>
                            
                            <?php for ($i = 1; $i <= $posts['last_page']; $i++): ?>
                                <li class="page-item <?= $i === $posts['current_page'] ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($posts['current_page'] < $posts['last_page']): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $posts['current_page'] + 1 ?>">Next</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-newspaper text-muted" style="font-size: 4rem;"></i>
                    <h4 class="text-muted mt-3">No posts found</h4>
                    <p class="text-muted">Check back later for new content!</p>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Categories</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($categories)): ?>
                        <ul class="list-unstyled mb-0">
                            <?php foreach ($categories as $category): ?>
                                <li class="mb-2">
                                    <a href="/category/<?= htmlspecialchars($category['slug']) ?>" 
                                       class="text-decoration-none d-flex justify-content-between align-items-center">
                                        <span>
                                            <i class="fas fa-folder" style="color: <?= htmlspecialchars($category['color']) ?>;"></i>
                                            <?= htmlspecialchars($category['name']) ?>
                                        </span>
                                        <span class="badge bg-secondary"><?= $category['post_count'] ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted mb-0">No categories available</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/app.php';
?>
