<?php

if (basename($_SERVER['PHP_SELF']) == 'config.php') {
    die('403 - Access Forbidden');
}

// DB Configuration
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'quiz');

// General Configuration
define('APP_TITLE', 'Character Quiz Maker');
define('API_VERSION', '1.0');