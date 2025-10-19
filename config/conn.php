<?php

function connectDB() {

    if ($_SERVER['HTTP_HOST'] === 'localhost') {
        $host = "localhost";
        $user = "root";
        $pass = "";
        $db   = "blog_db";
    } 
    
    // For Railway deployment
    else { 
        $host = getenv('MYSQLHOST');
        $user = getenv('MYSQLUSER');
        $pass = getenv('MYSQLPASSWORD');
        $db   = getenv('MYSQLDATABASE');
    }

    $connection = mysqli_connect($host, $user, $pass, $db);
    mysqli_set_charset($connection, "utf8mb4");

    if ($connection != false) {
        return $connection;
    } 
    else {
        // Show detailed error message
        die("Connection failed: " . mysqli_connect_error());
    }
}

?>