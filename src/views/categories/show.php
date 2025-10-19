<?php

require_once __DIR__ . '/../../../config/constants.php';

if (basename($_SERVER['SCRIPT_FILENAME']) === basename(__FILE__)) {  // This automatically redirects if someone accesses the file directly.
    header('Location: ' . BASE_PATH . 'index.php?page=categories-show');
    exit;
}

?>