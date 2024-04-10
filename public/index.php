<?php
require_once __DIR__ . '/../src/Config/config.php';

if (DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

require_once __DIR__ . '/../src/Router/Router.php';
require_once __DIR__ . '/../src/Helpers/db.php';
require_once __DIR__ . '/../src/Helpers/security.php';

spl_autoload_register(function ($class_name) {
    $basePath = __DIR__ . '/../src/';
    if (file_exists($basePath . 'Models/' . $class_name . '.php')) {
        require_once $basePath . 'Models/' . $class_name . '.php';
    } elseif (file_exists($basePath . 'Controllers/' . $class_name . '.php')) {
        require_once $basePath . 'Controllers/' . $class_name . '.php';
    }
});

// Include the routes
$router = require __DIR__ . '/../src/Router/routes.php';

// Dispatch the router
$router->dispatch();