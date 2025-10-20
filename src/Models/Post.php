<?php

class Post {

    // Get all posts
    public static function getAll($conn) {

        $List = array();
        $sql = "SELECT * FROM posts WHERE status != 'archived' ORDER BY created_at DESC";

        $result = mysqli_query($conn, $sql);

        $i = 0;
        while ($data = mysqli_fetch_array($result)) {
            $List[$i]['id'] = $data['id'];
            $List[$i]['title'] = $data['title'];
            $List[$i]['slug'] = $data['slug'];
            $List[$i]['content'] = $data['content'];
            $List[$i]['excerpt'] = $data['excerpt'];
            $List[$i]['featured_image'] = $data['featured_image'];
            $List[$i]['status'] = $data['status'];
            $List[$i]['author_id'] = $data['author_id'];
            $List[$i]['category_id'] = $data['category_id'];
            $List[$i]['meta_title'] = $data['meta_title'];
            $List[$i]['meta_description'] = $data['meta_description'];
            $List[$i]['created_at'] = $data['created_at'];
            $List[$i]['updated_at'] = $data['updated_at'];

            $i++;
        }

        return $List;
    }

    // Find post by ID
    public static function findById($conn, $id) {

        $List = array();
        $sql = "SELECT 
                    p.*, 
                    u.name AS author_name, 
                    c.name AS category_name 
                FROM posts p
                LEFT JOIN users u ON p.author_id = u.id
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE p.id = ?
            ";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($data = mysqli_fetch_array($result)) {
            $List['id'] = $data['id'];
            $List['title'] = $data['title'];
            $List['slug'] = $data['slug'];
            $List['content'] = $data['content'];
            $List['excerpt'] = $data['excerpt'];
            $List['featured_image'] = $data['featured_image'];
            $List['status'] = $data['status'];
            $List['author_id'] = $data['author_id'];
            $List['category_id'] = $data['category_id'];
            $List['meta_title'] = $data['meta_title'];
            $List['meta_description'] = $data['meta_description'];
            $List['created_at'] = $data['created_at'];
            $List['updated_at'] = $data['updated_at'];
            $List['author_name'] = $data['author_name'] ?? 'Unknown';
            $List['category_name'] = $data['category_name'] ?? 'Uncategorized';

            return $List;
        }

        return null;
    }

    // Create new post
    public static function createPost($conn, $title, $slug, $content, $excerpt, $featured_image, $author_id, $category_id, $meta_title, $meta_description) {

        $sql = "INSERT INTO posts (title, slug, content, excerpt, featured_image, status, author_id, category_id, meta_title, meta_description, created_at) 
                            VALUES (?, ?, ?, ?, ?, 'draft', ?, ?, ?, ?, CURRENT_TIMESTAMP)";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssiiss", $title, $slug, $content, $excerpt, $featured_image, $author_id, $category_id, $meta_title, $meta_description);

        return mysqli_stmt_execute($stmt);
    }

    // Update post
    public static function updatePost($conn, $id, $title, $slug, $content, $excerpt, $featured_image, $category_id, $meta_title, $meta_description, $status) {

        $sql = "UPDATE posts 
                SET title = ?, slug = ?, content = ?, excerpt = ?, featured_image = ?, category_id = ?, meta_title = ?, meta_description = ?, status = ?, updated_at = CURRENT_TIMESTAMP 
                WHERE id = ?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssisssi", $title, $slug, $content, $excerpt, $featured_image, $category_id, $meta_title, $meta_description, $status, $id);

        return mysqli_stmt_execute($stmt);
    }

    // Delete post (physical deletion)
    public static function deletePost($conn, $id) {

        $sql = "DELETE FROM posts WHERE id = ?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);

        return mysqli_stmt_execute($stmt);
    }

    // Logical deletion of the post 
    public static function archivePost($conn, $id) {

        $sql = "UPDATE posts SET status = 'archived', updated_at = CURRENT_TIMESTAMP WHERE id = ?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);

        return mysqli_stmt_execute($stmt);
    }

}

?>