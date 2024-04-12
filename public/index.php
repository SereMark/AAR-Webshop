<?php
// Include the configuration file
require_once __DIR__ . '/../src/Config/config.php';

// If debugging is enabled, display all errors
if (DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// Include the router, database helper, and security helper
require_once __DIR__ . '/../src/Router/Router.php';
require_once __DIR__ . '/../src/Helpers/db.php';
require_once __DIR__ . '/../src/Helpers/security.php';

// Register an autoloader for classes in the Models and Controllers directories
spl_autoload_register(function ($class_name) {
    $basePath = __DIR__ . '/../src/';
    if (file_exists($basePath . 'Models/' . $class_name . '.php')) {
        require_once $basePath . 'Models/' . $class_name . '.php';
    } elseif (file_exists($basePath . 'Controllers/' . $class_name . '.php')) {
        require_once $basePath . 'Controllers/' . $class_name . '.php';
    }
});

// Start the session if it's not already started
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Include the routes
$router = require __DIR__ . '/../src/Router/routes.php';

// Dispatch the router
$router->dispatch();