<?php

// Start Session
session_start();

// Include Configuration
require_once('config.php');

// Include Helpers
require_once('helpers/params.php');

// Autoloader
spl_autoload_register(function ($class_name) {
    // Autoload lib files
    if (file_exists("lib/{$class_name}.php")) {
        require_once("lib/{$class_name}.php");
    }

    // Autoload model files
    if (file_exists("model/{$class_name}.php")) {
        require_once("model/{$class_name}.php");
    }
});
