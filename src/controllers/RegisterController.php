<?php

require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . "/../../config/conn.php";
require_once __DIR__ . "/../utils/validateUser.php";

// Initialize error variables
$errorMessage = '';
$validations = '';

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['name']) &&
    isset($_POST['email']) &&
    isset($_POST['password']) &&
    isset($_POST['confirm_password'])) {

    $tbl_name = "users";
    $validations = validateUser(); // Optional: reuse the validation logic

    if (empty($validations)) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];

        // Basic password match check
        if ($password !== $confirmPassword) {

            $_SESSION['signup_error'] = "Passwords do not match.";
            $_SESSION['signup_email'] = $_POST['email'];
            $_SESSION['signup_name'] = $_POST['name'];
            header('Location: ' . BASE_PATH . 'index.php?page=users-register');
            exit;
        }

        $connection = connectDB();

        // Check if email already exists
        $stmt = $connection->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {

            $stmt->close();
            $connection->close();
            
            $_SESSION['signup_error'] = "Email is already registered.";
            $_SESSION['signup_email'] = $_POST['email'];
            $_SESSION['signup_name'] = $_POST['name'];
            header('Location: ' . BASE_PATH . 'index.php?page=users-register');
            exit;
        }

        $stmt->close();

        // Insert new user (be aware: no cryptography, demo mode!)
        $stmt = $connection->prepare("INSERT INTO users (name, email, password, role, status, created_at, updated_at) 
                                                 VALUES (?, ?, ?, 'user', 'active', NOW(), NOW())");
        $stmt->bind_param("sss", $name, $email, $password);
        $success = $stmt->execute();

        if ($success) {
            $newUserId = $stmt->insert_id;

            $_SESSION['user'] = [
                'id' => $newUserId,
                'name' => $name,
                'email' => $email,
                'role' => 'Sr Author',
                'avatar' => null,
                'bio' => '',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        
            $stmt->close();
            $connection->close();

            header('Location: ' . BASE_PATH . 'index.php?page=users-profile');
            exit;
        } 
        else {
            $errorMessage = "Registration failed. Please try again.";
        }

        $stmt->close();
        $connection->close();
    } 
    else {
        $errorMessage = "Validation failed. Please check your input.";
    }
}

// Alert placeholder for register.php
if (!empty($errorMessage)) {
    $_SESSION['signup_error'] = $errorMessage;
    $_SESSION['signup_validations'] = $validations;
    $_SESSION['signup_email'] = $_POST['email']; // Thesse are for the fields in the form!
    $_SESSION['signup_name'] = $_POST['name']; 
    header('Location: ' . BASE_PATH . 'index.php?page=users-register');
    exit;
}