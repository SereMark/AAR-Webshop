<?php
// Include the configuration file
require_once __DIR__ . '/../src/Config/config.php';

// If debugging is enabled, display all errors
if (DEBUG) {
    // Display errors during script execution
    ini_set('display_errors', 1);
    // Display errors that occur during PHP's startup sequence
    ini_set('display_startup_errors', 1);
    // Report all types of errors
    error_reporting(E_ALL);
}

// Register an autoloader for classes in the Models and Controllers directories
spl_autoload_register(function ($class_name) {
    // Base path for Models and Controllers directories
    $basePath = __DIR__ . '/../src/';
    // Check if the class exists in the Models directory
    if (file_exists($basePath . 'Models/' . $class_name . '.php')) {
        // Include the class file from the Models directory
        require_once $basePath . 'Models/' . $class_name . '.php';
    // Check if the class exists in the Controllers directory
    } elseif (file_exists($basePath . 'Controllers/' . $class_name . '.php')) {
        // Include the class file from the Controllers directory
        require_once $basePath . 'Controllers/' . $class_name . '.php';
    }
});

// Start the session if it's not already started
if (session_status() !== PHP_SESSION_ACTIVE) {
    // Start a new session or resume the existing one
    session_start();
}

// Include the Router and the routes
require_once __DIR__ . '/../src/Router/Router.php';
// Load the routes configuration
$router = require __DIR__ . '/../src/Router/routes.php';

// Dispatch the router
// Handle the incoming request and route it to the appropriate controller/action
$router->dispatch();
?>