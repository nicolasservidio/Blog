<?php

// We need to install Composer: https://getcomposer.org/download/ (requires that you have PHP (standalone PHP, not just XAMPP) already installed)
// We need to install vlucas/phpdotenv: with Composer or manual installation using the repo at https://github.com/vlucas/phpdotenv 

// We need to load Composer's autoloader to access external packages like vlucas/phpdotenv
require_once __DIR__ . '/../vendor/autoload.php';

// Then, we initialize vlucas/phpdotenv's "Dotenv" to load environment variables from the local .env file, but only in the local environment (.env file is not uploaded to platforms like Railway). This only works in local environments like XAMPP — platforms like Railway inject variables automatically, and we never upload an .env file to GitHub, Railway and so on (i.e. we will have a fatal error if we try to load a non-existing .env file on Railway)
$envPath = __DIR__ . '/../.env';  // Path to the .env file
if (file_exists($envPath)) {  // Check if .env file exists (i.e., we are in a local environment) 
    $dotenv = Dotenv\Dotenv::createMutable(__DIR__ . '/../');
    $dotenv->load();
    error_log("✅ Environment loaded from .env file in a local environment");
} 
else {
    error_log("✅ Environment loaded from platform injection (e.g., Railway)");
}

// And now we need the function to connect to MySQL using the environment variables from .env, Railway or any other platform:

function connectDB() {

    // Retrieve database connection values from the environment. These are injected in production by deployment platforms like Railway, or loaded from .env locally:

    $host = $_ENV['MYSQLHOST'] ?? null;       // e.g., "localhost" (XAMPP) or "containers.uprailway.app" (Railway)
    $user = $_ENV['MYSQLUSER'] ?? null;       // e.g., "root"
    $pass = $_ENV['MYSQLPASSWORD'] ?? null;   // e.g., "" (XAMPP) or Railway-generated password
    $db   = $_ENV['MYSQLDATABASE'] ?? null;   // e.g., "blog_db"
    $port = $_ENV['MYSQLPORT'] ?? 3306;       // e.g., "3306"

    // Establish connection using mysqli with all parameters, including port
    $connection = mysqli_connect($host, $user, $pass, $db, $port);

    // Set character encoding to utf8mb4 for full Unicode support (e.g., emojis, accents)
    mysqli_set_charset($connection, "utf8mb4");

    // Return the connection if successful, or show detailed error if it fails
    if ($connection != false) {
        return $connection;
    } 
    else {
        // 🛑 Fail loudly with full error message for debugging and audit
        die("Connection failed: " . mysqli_connect_error());
    }
}


/* This is no longer necessary since I am using environmental variables in an .env file, but kept for reference.

function connectDB() {

    // Local deployment with XAMPP
    if ($_SERVER['HTTP_HOST'] === 'localhost') {
        $host = "localhost";
        $user = "root";
        $pass = "";
        $db   = "blog_db";
        $port = 3306;
    } 
    
    // For Railway deployment
    else { 
        $host = getenv('MYSQLHOST');
        $user = getenv('MYSQLUSER');
        $pass = getenv('MYSQLPASSWORD');
        $db   = getenv('MYSQLDATABASE');
        $port = getenv('MYSQLPORT');
    }

    $connection = mysqli_connect($host, $user, $pass, $db, $port);
    mysqli_set_charset($connection, "utf8mb4");

    if ($connection != false) {
        return $connection;
    } 
    else {
        // Show detailed error message
        die("Connection failed: " . mysqli_connect_error());
    }
}
*/

?>