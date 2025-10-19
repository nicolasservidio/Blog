<?php
require_once __DIR__ . "/../../config/conn.php";
require_once __DIR__ . "/../utils/validateUser.php";


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

        $stmt->close();
        $connection->close();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verify password securely
            if ($password == $user['password']) { // this is just for the demo, since we are not using cryptographic validations here, but you should

                // Store user data in session (compatible with header.php)
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['name'], // or $user['username'] if available
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'avatar' => $user['avatar'],
                    'bio' => $user['bio'],
                    'status' => $user['status'],
                    'created_at' => $user['created_at'],
                    'updated_at' => $user['updated_at']
                ];

                // Optional role label overrides
                if ($_SESSION['user']['role'] === 'admin') {
                    $_SESSION['user']['role'] = 'Sr Administrator';
                }
                if ($_SESSION['user']['role'] != 'admin') {
                    $_SESSION['user']['role'] = 'Sr Author';
                }

                // Redirects to the main panel
                header('Location: ../views/users/profile.php');
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
if (!empty($errorMessage)): ?>
    <div class="alert-custom alert-error">
        <?= htmlspecialchars($errorMessage) ?>
        <?= htmlspecialchars($validations) ?>
    </div>
<?php endif; ?>

