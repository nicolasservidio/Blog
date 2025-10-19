<?php

class Category {

    // Get all categories
    public static function getAll($conn) {
        
        $List = array();
        $sql = "SELECT * FROM categories ORDER BY name ASC";

        $result = mysqli_query($conn, $sql);

        $i = 0;
        while ($data = mysqli_fetch_array($result)) {
            $List[$i]['id'] = $data['id'];
            $List[$i]['name'] = $data['name'];
            $List[$i]['slug'] = $data['slug'];
            $List[$i]['description'] = $data['description'];
            $List[$i]['color'] = $data['color'];
            $List[$i]['status'] = $data['status'];
            $List[$i]['created_at'] = $data['created_at'];
            $List[$i]['updated_at'] = $data['updated_at'];

            $i++;
        }

        return $List;
    }

    // Find category by ID
    public static function findById($conn, $id) {

        $List = array();
        $sql = "SELECT * FROM categories WHERE id = ?";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($data = mysqli_fetch_array($result)) {
            $List['id'] = $data['id'];
            $List['name'] = $data['name'];
            $List['slug'] = $data['slug'];
            $List['description'] = $data['description'];
            $List['color'] = $data['color'];
            $List['status'] = $data['status'];
            $List['created_at'] = $data['created_at'];
            $List['updated_at'] = $data['updated_at'];
            return $List;
        }

        return null;
    }

    // Create new category
    public static function createCategory($conn, $name, $slug, $description) {

        $sql = "INSERT INTO categories (name, slug, description, status, created_at) VALUES (?, ?, ?, 'active', CURRENT_TIMESTAMP)";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $name, $slug, $description);

        return mysqli_stmt_execute($stmt);
    }

    // Update category
    public static function updateCategory($conn, $id, $name, $slug, $description, $status) {

        $sql = "UPDATE categories SET name = ?, slug = ?, description = ?, status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $name, $slug, $description, $status, $id);

        return mysqli_stmt_execute($stmt);
    }

    // Delete category
    public static function deleteCategory($conn, $id) {

        $sql = "DELETE FROM categories WHERE id = ?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);

        return mysqli_stmt_execute($stmt);
    }
}

?>