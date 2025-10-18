<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;

/**
 * Admin Controller
 * Handles admin dashboard and content management
 */
class AdminController extends Controller
{
    private Post $postModel;
    private Category $categoryModel;
    private User $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->requireAuth();
        $this->postModel = new Post();
        $this->categoryModel = new Category();
        $this->userModel = new User();
    }

    /**
     * Admin dashboard
     */
    public function index(): void
    {
        $postStats = $this->postModel->getStats();
        $userStats = $this->userModel->getStats();
        $recentPosts = $this->postModel->getRecent(5);

        $this->view('admin/dashboard', [
            'title' => 'Admin Dashboard',
            'post_stats' => $postStats,
            'user_stats' => $userStats,
            'recent_posts' => $recentPosts
        ]);
    }

    /**
     * Posts management
     */
    public function posts(): void
    {
        $page = (int) $this->input('page', 1);
        $posts = $this->postModel->getWithRelations();
        
        // Simple pagination
        $perPage = 10;
        $total = count($posts);
        $posts = array_slice($posts, ($page - 1) * $perPage, $perPage);

        $this->view('admin/posts/index', [
            'title' => 'Manage Posts',
            'posts' => $posts,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'last_page' => ceil($total / $perPage)
            ]
        ]);
    }

    /**
     * Create post form
     */
    public function createPost(): void
    {
        $categories = $this->categoryModel->getActive();

        $this->view('admin/posts/create', [
            'title' => 'Create New Post',
            'categories' => $categories,
            'csrf_token' => $this->csrfToken()
        ]);
    }

    /**
     * Store new post
     */
    public function storePost(): void
    {
        if (!$this->isPost()) {
            $this->redirect('/admin/posts/create');
        }

        if (!$this->validateCsrf()) {
            $this->flash('error', 'Invalid CSRF token');
            $this->redirect('/admin/posts/create');
        }

        $title = trim($this->input('title'));
        $content = $this->input('content');
        $excerpt = trim($this->input('excerpt'));
        $categoryId = (int) $this->input('category_id');
        $status = $this->input('status', 'draft');
        $featuredImage = $this->input('featured_image');

        // Validate input
        $errors = $this->validatePost($title, $content, $categoryId);
        
        if (!empty($errors)) {
            foreach ($errors as $error) {
                $this->flash('error', $error);
            }
            $this->redirect('/admin/posts/create');
        }

        try {
            $slug = $this->postModel->generateSlug($title);
            
            $postId = $this->postModel->create([
                'title' => $title,
                'slug' => $slug,
                'content' => $content,
                'excerpt' => $excerpt,
                'category_id' => $categoryId ?: null,
                'status' => $status,
                'featured_image' => $featuredImage,
                'author_id' => $this->getUserId()
            ]);

            $this->flash('success', 'Post created successfully!');
            $this->redirect('/admin/posts');
        } catch (\Exception $e) {
            $this->flash('error', 'Failed to create post. Please try again.');
            $this->redirect('/admin/posts/create');
        }
    }

    /**
     * Edit post form
     */
    public function editPost(int $id): void
    {
        $post = $this->postModel->find($id);
        
        if (!$post) {
            $this->flash('error', 'Post not found');
            $this->redirect('/admin/posts');
        }

        $categories = $this->categoryModel->getActive();

        $this->view('admin/posts/edit', [
            'title' => 'Edit Post',
            'post' => $post,
            'categories' => $categories,
            'csrf_token' => $this->csrfToken()
        ]);
    }

    /**
     * Update post
     */
    public function updatePost(int $id): void
    {
        if (!$this->isPost()) {
            $this->redirect('/admin/posts');
        }

        if (!$this->validateCsrf()) {
            $this->flash('error', 'Invalid CSRF token');
            $this->redirect('/admin/posts');
        }

        $post = $this->postModel->find($id);
        if (!$post) {
            $this->flash('error', 'Post not found');
            $this->redirect('/admin/posts');
        }

        $title = trim($this->input('title'));
        $content = $this->input('content');
        $excerpt = trim($this->input('excerpt'));
        $categoryId = (int) $this->input('category_id');
        $status = $this->input('status', 'draft');
        $featuredImage = $this->input('featured_image');

        // Validate input
        $errors = $this->validatePost($title, $content, $categoryId);
        
        if (!empty($errors)) {
            foreach ($errors as $error) {
                $this->flash('error', $error);
            }
            $this->redirect('/admin/posts/' . $id . '/edit');
        }

        try {
            $slug = $this->postModel->generateSlug($title);
            
            $this->postModel->update($id, [
                'title' => $title,
                'slug' => $slug,
                'content' => $content,
                'excerpt' => $excerpt,
                'category_id' => $categoryId ?: null,
                'status' => $status,
                'featured_image' => $featuredImage
            ]);

            $this->flash('success', 'Post updated successfully!');
            $this->redirect('/admin/posts');
        } catch (\Exception $e) {
            $this->flash('error', 'Failed to update post. Please try again.');
            $this->redirect('/admin/posts/' . $id . '/edit');
        }
    }

    /**
     * Delete post
     */
    public function deletePost(int $id): void
    {
        if (!$this->isPost()) {
            $this->redirect('/admin/posts');
        }

        if (!$this->validateCsrf()) {
            $this->flash('error', 'Invalid CSRF token');
            $this->redirect('/admin/posts');
        }

        $post = $this->postModel->find($id);
        if (!$post) {
            $this->flash('error', 'Post not found');
            $this->redirect('/admin/posts');
        }

        try {
            $this->postModel->delete($id);
            $this->flash('success', 'Post deleted successfully!');
        } catch (\Exception $e) {
            $this->flash('error', 'Failed to delete post. Please try again.');
        }

        $this->redirect('/admin/posts');
    }

    /**
     * Categories management
     */
    public function categories(): void
    {
        $categories = $this->categoryModel->getWithPostCount();

        $this->view('admin/categories/index', [
            'title' => 'Manage Categories',
            'categories' => $categories,
            'csrf_token' => $this->csrfToken()
        ]);
    }

    /**
     * Store new category
     */
    public function storeCategory(): void
    {
        if (!$this->isPost()) {
            $this->redirect('/admin/categories');
        }

        if (!$this->validateCsrf()) {
            $this->flash('error', 'Invalid CSRF token');
            $this->redirect('/admin/categories');
        }

        $name = trim($this->input('name'));
        $description = trim($this->input('description'));
        $color = $this->input('color', '#007bff');

        if (empty($name)) {
            $this->flash('error', 'Category name is required');
            $this->redirect('/admin/categories');
        }

        if ($this->categoryModel->nameExists($name)) {
            $this->flash('error', 'Category name already exists');
            $this->redirect('/admin/categories');
        }

        try {
            $slug = $this->categoryModel->generateSlug($name);
            
            $this->categoryModel->create([
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'color' => $color
            ]);

            $this->flash('success', 'Category created successfully!');
        } catch (\Exception $e) {
            $this->flash('error', 'Failed to create category. Please try again.');
        }

        $this->redirect('/admin/categories');
    }

    /**
     * Users management
     */
    public function users(): void
    {
        $users = $this->userModel->all();

        $this->view('admin/users/index', [
            'title' => 'Manage Users',
            'users' => $users
        ]);
    }

    /**
     * Validate post data
     */
    private function validatePost(string $title, string $content, int $categoryId): array
    {
        $errors = [];

        if (empty($title) || strlen($title) < 3) {
            $errors[] = 'Title must be at least 3 characters long';
        }

        if (empty($content) || strlen($content) < 10) {
            $errors[] = 'Content must be at least 10 characters long';
        }

        if ($categoryId && !$this->categoryModel->find($categoryId)) {
            $errors[] = 'Selected category does not exist';
        }

        return $errors;
    }
}
