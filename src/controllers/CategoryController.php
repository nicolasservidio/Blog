<?php

require_once __DIR__ . '/../models/Category.php';

class CategoryController {

    // List all categories. The method "index()" is the MVC controller method for a clean list retrieval of all the registered resources
    // It delegates to the model's getAll() method and returns the full dataset to the view layer for listing or iteration.
    public static function index($conn) {

        $List = Category::getAll($conn);
        return $List;
    }

    // Prepare data for category creation. The method "create()" is the MVC controller method that prepares the form for creating a new resource
    public static function create($conn) {

        $List = array(); // No dependencies needed for category creation (you can see it this way: the "categories" table in the DB does not need data from the other tables)
        return $List;
    }

    // Store new category. The method "store()" is the MVC controller method that receives form submission and inserts the new category
    public static function store($conn, $name, $slug, $description) {

        $result = Category::createCategory($conn, $name, $slug, $description); // As you can see in the Model's method and DB, there is not need to define color or status in the creation of a category
        return $result;
    }

    // Load category for editing. The method "edit()" is the MVC controller method that loads a resource for editing
    // It retrieves the current data (e.g., a category) so the view can render a pre-filled form.
    public static function edit($conn, $id) {

        $List = array();
        $List['category'] = Category::findById($conn, $id); // asking for the requested category, so that i can prepare it for editing (i.e., for an update)

        return $List;
    }

    // Apply category updates. The method "update()" is the MVC controller method that receives the form submission and applies changes to the resource
    // It calls the model’s update method and refreshes the "updated_at" timestamp automatically
    public static function update($conn, $id, $name, $slug, $description, $status) {

        $result = Category::updateCategory($conn, $id, $name, $slug, $description, $status);
        return $result;
    }

    // Delete category. The method "delete()" is the MVC controller method that removes the resource from the database
    // It calls the model’s delete method and returns the result to the router or view layer
    public static function delete($conn, $id) {

        $result = Category::deleteCategory($conn, $id);
        return $result;
    }
}

?>