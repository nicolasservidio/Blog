<?php

require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . "/../../config/conn.php";
require_once __DIR__ . "/../utils/validateUser.php";


if (session_status() === PHP_SESSION_NONE) { // Session starts only if not already active
    session_start();
}

// Initialize the error variable
$errorMessage = '';
$validations = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['password'])) {

    $tbl_name = "users"; // Table name in the DB 
    $validations = validateUser();

    if (empty($validations)) {

        $email = $_POST['email'];  // Email entered, processed and validated
        $password = $_POST['password']; // Password entered, processed and validated

        $connection = connectDB();
    
        // Secure query: fetch user by email and password, no cryptography since this is just a demo
        $stmt = $connection->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            $stmt->close();
            $connection->close();

            // Verify password securely
            if ($password == $user['password']) { // this is just for the demo, since we are not using cryptographic validations here, but you should

                unset($_SESSION['user']); // Pre-session cleanup. This prevents residual data from being left behind if the login is repeated.
                // Store user data in session (compatible with header.php)
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'name' => $user['name'], // or $user['username'] if available
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'avatar' => $user['avatar'],
                    'bio' => $user['bio'],
                    'status' => $user['status'],
                    'created_at' => $user['created_at'],
                    'updated_at' => $user['updated_at']
                ];

                // Optional role label overrides
                switch ($user['role']) {
                    case 'admin':
                        $_SESSION['user']['role'] = 'Sr Administrator';
                        break;
                    case 'user':
                        $_SESSION['user']['role'] = 'Sr Author';
                        break;
                    default:
                        $_SESSION['user']['role'] = 'Your role';
                        break;
                }

                // Redirects to the main panel
                header('Location: ' . BASE_PATH . 'index.php?page=users-profile');
                exit;
            }
            else {
                $errorMessage = "Incorrect password.";
            }
        }
        else {
            $errorMessage = "User not found.";
        }
    }
    else {
        $errorMessage = "Validation failed. Please check your input.";
    }
}

// Alert placeholder for login.php
if (!empty($errorMessage)) {
    $_SESSION['login_error'] = $errorMessage;
    $_SESSION['login_validations'] = $validations;
    $_SESSION['login_email'] = $_POST['email']; // This for the field in the form!
    header('Location: ' . BASE_PATH . 'index.php?page=users-login');
    exit;
}
