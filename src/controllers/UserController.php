<?php

require_once __DIR__ . '/../models/User.php';

class UserController {

    // List all users (i.e., authors of the blog). The method "index()" is the MVC controller method for a clean list retrieval of all the registered resources
    // It delegates to the model's getAll() method and returns the full dataset to the view layer for listing or iteration.
    public static function index($conn) {

        $List = User::getAll($conn);
        return $List;
    }

    // Prepare data for user (= author) creation. The method "create()" is the MVC controller method that prepares the form for creating a new resource
    public static function create($conn) {

        $List = array(); // As in the "category" controller, there is no need of dependencies for user creation, you just need and empty array for attributes of the author
        return $List;
    }

    // Store new user. The method "store()" is the MVC controller method that receives form submission and inserts the new user
    public static function store($conn, $name, $email, $password) {

        $result = User::createUser($conn, $name, $email, $password);
        return $result;
    }

    // Load user for editing. The method "edit()" is the MVC controller method that loads a resource for editing
    // It retrieves the current data (e.g., a user) so the view can render a pre-filled form.
    public static function edit($conn, $id) {

        $List = array();
        $List['user'] = User::findById($conn, $id);

        return $List;
    }

    // Apply user profile updates. The method "updateProfile()" is the MVC controller method that receives the form submission and applies changes to the resource
    // It calls the model’s updateProfile method and refreshes the "updated_at" timestamp automatically
    public static function updateProfile($conn, $id, $name, $avatar, $bio) {

        $result = User::updateProfile($conn, $id, $name, $avatar, $bio);
        return $result;
    }

    // Apply user credential updates. The method "updateCredentials()" is the MVC controller method that receives the form submission and applies changes to the resource
    // It calls the model’s updateCredentials method and refreshes the "updated_at" timestamp automatically
    public static function updateCredentials($conn, $id, $email, $password) {

        $result = User::updateCredentials($conn, $id, $email, $password);
        return $result;
    }

    // Apply full user updates. The method "updateFull()" is the MVC controller method that receives the form submission and applies changes to the resource
    // It calls the model’s updateFull method and refreshes the "updated_at" timestamp automatically
    public static function updateFull($conn, $id, $name, $email, $password, $role, $avatar, $bio, $status) {

        $result = User::updateFull($conn, $id, $name, $email, $password, $role, $avatar, $bio, $status);
        return $result;
    }

    // Delete user. The method "delete()" is the MVC controller method that removes the resource from the database
    // It calls the model’s delete method and returns the result to the router or view layer
    public static function delete($conn, $id) {

        $result = User::deleteUser($conn, $id);
        return $result;
    }
}

?>