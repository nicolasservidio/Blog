<?php

function validateUser(): string {

    // Sanitize input
    $email = isset($_POST['email']) ? strip_tags(trim($_POST['email'])) : '';
    $password = isset($_POST['password']) ? strip_tags(trim($_POST['password'])) : '';

    // Overwrite sanitized values back into $_POST for consistency
    $_POST['email'] = $email;
    $_POST['password'] = $password;

    // Initialize error collector
    $errors = [];

    // Email validations
    if (empty($email)) {
        $errors[] = "- The email field cannot be empty.";
    } 
    elseif (strlen($email) < 4 || strlen($email) > 50) {
        $errors[] = "- The email must be between 4 and 50 characters.";
    } 
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "- The email format is invalid.";
    }

    // Password validations
    if (empty($password)) {
        $errors[] = "- The password field cannot be empty.";
    } 
    elseif (strlen($password) < 8) {
        $errors[] = "- The password must be at least 8 characters long.";
    }

    // Compile error messages from the array
    if (!empty($errors)) {
        return '<br><br>' . implode('<br>', $errors);
    }

    return '';
}

?>
