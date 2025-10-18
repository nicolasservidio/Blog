<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;
use App\Models\Category;

/**
 * Home Controller
 * Handles public pages
 */
class HomeController extends Controller
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
     * Home page
     */
    public function index(): void
    {
        $posts = $this->postModel->getRecent(6);
        $categories = $this->categoryModel->getWithPostCount();

        $this->view('home/index', [
            'title' => 'Welcome to Our Blog',
            'posts' => $posts,
            'categories' => $categories
        ]);
    }

    /**
     * About page
     */
    public function about(): void
    {
        $this->view('home/about', [
            'title' => 'About Us'
        ]);
    }

    /**
     * Contact page
     */
    public function contact(): void
    {
        $this->view('home/contact', [
            'title' => 'Contact Us',
            'csrf_token' => $this->csrfToken()
        ]);
    }
}
