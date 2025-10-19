<?php

require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Category.php';

class PostController {

    // List all posts. The method "index()" is the MVC controller method for a clean list retrieval of all the registered resources
    // It delegates to the model's getAll() method and returns the full dataset to the view layer for listing or iteration.
    public static function index($conn) {

        $List = Post::getAll($conn);
        return $List;
    }

    // Prepare data for post creation. The method "create()" is the MVC controller method that prepares the form for creating a new resource
    public static function create($conn) {

        $List = array();
        $List['authors'] = User::getAll($conn);
        $List['categories'] = Category::getAll($conn);

        return $List;
    }

    // Store new post. The method "store()" is the MVC controller method that receives form submission and inserts the new post
    public static function store($conn, $title, $slug, $content, $excerpt, $featured_image, $author_id, $category_id, $meta_title, $meta_description) {

        $result = Post::createPost($conn, $title, $slug, $content, $excerpt, $featured_image, $author_id, $category_id, $meta_title, $meta_description);
        return $result;
    }

    // Load post for editing. The method "edit()" is the MVC controller method that loads a resource for editing
    // It retrieves the current data (e.g., a post) and any related entities (e.g. authors, categories) so the view can render a pre-filled form.
    public static function edit($conn, $id) {

        $List = array();
        $List['post'] = Post::findById($conn, $id);
        $List['authors'] = User::getAll($conn);
        $List['categories'] = Category::getAll($conn);

        return $List;
    }

    // Apply post updates. The method "update()" is the MVC controller method that receives the form submission and applies changes to the resource
    // It calls the model’s update method and refreshes the "updated_at" timestamp automatically
    public static function update($conn, $id, $title, $slug, $content, $excerpt, $featured_image, $category_id, $meta_title, $meta_description, $status) {

        $result = Post::updatePost($conn, $id, $title, $slug, $content, $excerpt, $featured_image, $category_id, $meta_title, $meta_description, $status);
        return $result;
    }

    // Delete post. The method "delete()" is the MVC controller method that removes the resource from the database
    // It calls the model’s delete method and returns the result to the router or view layer
    public static function delete($conn, $id) {

        $result = Post::deletePost($conn, $id);
        return $result;
    }
}

?>