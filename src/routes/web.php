<?php

use App\Core\Application;

$router = Application::getInstance()->getRouter();

// Home routes
$router->get('/', 'HomeController', 'index');
$router->get('/about', 'HomeController', 'about');
$router->get('/contact', 'HomeController', 'contact');

// Blog routes
$router->get('/blog', 'BlogController', 'index');
$router->get('/blog/{slug}', 'BlogController', 'show');
$router->get('/category/{slug}', 'BlogController', 'category');

// Authentication routes
$router->get('/login', 'AuthController', 'showLogin');
$router->post('/login', 'AuthController', 'login');
$router->get('/register', 'AuthController', 'showRegister');
$router->post('/register', 'AuthController', 'register');
$router->post('/logout', 'AuthController', 'logout');

// Admin routes (protected)
$router->middleware(['AuthMiddleware'], function($router) {
    $router->get('/admin', 'AdminController', 'index');
    $router->get('/admin/posts', 'AdminController', 'posts');
    $router->get('/admin/posts/create', 'AdminController', 'createPost');
    $router->post('/admin/posts', 'AdminController', 'storePost');
    $router->get('/admin/posts/{id}/edit', 'AdminController', 'editPost');
    $router->put('/admin/posts/{id}', 'AdminController', 'updatePost');
    $router->delete('/admin/posts/{id}', 'AdminController', 'deletePost');
    $router->get('/admin/categories', 'AdminController', 'categories');
    $router->post('/admin/categories', 'AdminController', 'storeCategory');
    $router->get('/admin/users', 'AdminController', 'users');
});
