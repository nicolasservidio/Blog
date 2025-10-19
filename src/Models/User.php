<?php

class User {

    // Get all users
    public static function getAll($conn) {

        $List = array();
        $sql = "SELECT * FROM users ORDER BY created_at DESC";

        $result = mysqli_query($conn, $sql);

        $i=0;
        while ($data = mysqli_fetch_array($result)) {
            $List[$i]['id'] = $data['id'];
            $List[$i]['name'] = $data['name'];
            $List[$i]['email'] = $data['email'];
            $List[$i]['role'] = $data['role'];
            $List[$i]['avatar'] = $data['avatar'];
            $List[$i]['bio'] = $data['bio'];
            $List[$i]['status'] = $data['status'];
            $List[$i]['created_at'] = $data['created_at'];
            $List[$i]['updated_at'] = $data['updated_at'];

            $i++;
        }

        return $List; 
    }

    // Find user by ID
    public static function findById($conn, $id) {

        $List = array();
        $sql = "SELECT * FROM users WHERE id = ?";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($data = mysqli_fetch_array($result)) {
            $List['id'] = $data['id'];
            $List['name'] = $data['name'];
            $List['email'] = $data['email'];
            $List['role'] = $data['role'];
            $List['avatar'] = $data['avatar'];
            $List['bio'] = $data['bio'];
            $List['status'] = $data['status'];
            $List['created_at'] = $data['created_at'];
            $List['updated_at'] = $data['updated_at'];
            return $List;
        }

        return null;
    }

    // Find user by email
    public static function findByEmail($conn, $email) {

        $List = array();
        $sql = "SELECT * FROM users WHERE email = ?";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($data = mysqli_fetch_array($result)) {
            $List['id'] = $data['id'];
            $List['name'] = $data['name'];
            $List['email'] = $data['email'];
            $List['role'] = $data['role'];
            $List['avatar'] = $data['avatar'];
            $List['bio'] = $data['bio'];
            $List['status'] = $data['status'];
            $List['created_at'] = $data['created_at'];
            $List['updated_at'] = $data['updated_at'];
            return $List;
        }

        return null;
    }

    // Create new user (i.e., author of the blog)
    public static function createUser($conn, $name, $email, $password, $role = 'user', $status = 'active') {
        
        $sql = "INSERT INTO users (name, email, password, role, status) VALUES (?, ?, ?, ?, ?)";  // Well, in reality... role and status are predefined by default in the DB, but here I show that those values can also be predefined from here, the model layer code

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $password, $role, $status);
        return mysqli_stmt_execute($stmt);
    }

    // Update user profile (i.e., just the name, avatar and bio)
    public static function updateProfile($conn, $id, $name, $avatar, $bio) {

        $sql = "UPDATE users SET name = ?, avatar = ?, bio = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "sssi", $name, $avatar, $bio, $id);
        return mysqli_stmt_execute($stmt);
    }

    // Update user credentials (i.e., just the email and password)
    public static function updateCredentials($conn, $id, $email, $password) {

        $sql = "UPDATE users SET email = ?, password = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "ssi", $email, $password, $id);
        return mysqli_stmt_execute($stmt);
    }

    // Update full user data (i.e., name, email, password, avatar and bio). Optional, for admin-level
    public static function updateFull($conn, $id, $name, $email, $password, $role, $avatar, $bio, $status) {

        $sql = "UPDATE users SET name = ?, email = ?, password = ?, role = ?, avatar = ?, bio = ?, status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "sssssssi", $name, $email, $password, $role, $avatar, $bio, $status, $id);
        return mysqli_stmt_execute($stmt);
    }

    // Delete user. This to perform a logical deletion instead of a physical one
    public static function deleteUser($conn, $id) {

        $sql = "UPDATE users SET status = 'inactive' WHERE id = ?";

        $stmt = mysqli_prepare($conn, $sql);
        
        mysqli_stmt_bind_param($stmt, "i", $id);
        return mysqli_stmt_execute($stmt);
    }
}

?>