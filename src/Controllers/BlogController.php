<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;
use App\Models\Category;

/**
 * Blog Controller
 * Handles blog-related pages
 */
class BlogController extends Controller
{
    private Post $postModel;
    private Category $categoryModel;

    public function __construct()
    {
        parent::__construct();
        $this->postModel = new Post();
        $this->categoryModel = new Category();
    }

    /**
     * Blog listing page
     */
    public function index(): void
    {
        $page = (int) $this->input('page', 1);
        $posts = $this->postModel->paginate($page, 10);
        $categories = $this->categoryModel->getWithPostCount();

        $this->view('blog/index', [
            'title' => 'Blog',
            'posts' => $posts,
            'categories' => $categories
        ]);
    }

    /**
     * Single blog post
     */
    public function show(string $slug): void
    {
        $post = $this->postModel->findBySlug($slug);
        
        if (!$post || $post['status'] !== 'published') {
            http_response_code(404);
            $this->view('errors/404', [
                'title' => 'Post Not Found'
            ]);
            return;
        }

        // Get post with relations
        $post = $this->postModel->getWithRelationsById($post['id']);
        
        // Get related posts
        $relatedPosts = $this->postModel->getByCategory($post['category_id']);
        $relatedPosts = array_filter($relatedPosts, function($p) use ($post) {
            return $p['id'] !== $post['id'] && $p['status'] === 'published';
        });
        $relatedPosts = array_slice($relatedPosts, 0, 3);

        $this->view('blog/show', [
            'title' => $post['title'],
            'post' => $post,
            'related_posts' => $relatedPosts
        ]);
    }

    /**
     * Posts by category
     */
    public function category(string $slug): void
    {
        $category = $this->categoryModel->findBySlug($slug);
        
        if (!$category || $category['status'] !== 'active') {
            http_response_code(404);
            $this->view('errors/404', [
                'title' => 'Category Not Found'
            ]);
            return;
        }

        $page = (int) $this->input('page', 1);
        $posts = $this->postModel->getByCategory($category['id']);
        $posts = array_filter($posts, function($post) {
            return $post['status'] === 'published';
        });

        // Simple pagination
        $perPage = 10;
        $total = count($posts);
        $posts = array_slice($posts, ($page - 1) * $perPage, $perPage);

        $this->view('blog/category', [
            'title' => $category['name'],
            'category' => $category,
            'posts' => $posts,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'last_page' => ceil($total / $perPage)
            ]
        ]);
    }
}
