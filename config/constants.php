<?php
// Detect base path dynamically
$scriptName = $_SERVER['SCRIPT_NAME']; // e.g. /proyectos/Blog/public/index.php
$scriptDir = dirname($scriptName);     // e.g. /proyectos/Blog/public

// Ensure trailing slash
define('BASE_PATH', rtrim($scriptDir, '/') . '/');

