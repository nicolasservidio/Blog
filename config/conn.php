<?php

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

?>