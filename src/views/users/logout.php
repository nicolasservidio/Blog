<?php
require_once __DIR__ . '/../../../config/constants.php';

if (basename($_SERVER['SCRIPT_FILENAME']) === basename(__FILE__)) {  // This automatically redirects if someone accesses the file directly. It's a protection against direct access by the URL
    header('Location: ' . BASE_PATH . 'index.php?page=users-logout');
    exit;
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Destroying the session
$_SESSION = [];
session_unset();
session_destroy();

// Redirecting to login
header('Location: ' . BASE_PATH . 'index.php?page=users-login');
exit;