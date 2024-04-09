<?php

$router = new Router();

$router->get('/login', function () {
    require __DIR__ . '/../Views/login.php';
});

$router->post('/login', function () {
    $controller = new LoginController();
    $controller->login();
});

$router->get('/register', function () {
    require __DIR__ . '/../Views/register.php';
});

$router->post('/register', function () {
    $controller = new RegistrationController();
    $controller->register();
});

// Define more routes here

$router->setNotFoundHandler(function () {
    header('HTTP/1.0 404 Not Found');
    echo '404 Not Found';
});

return $router;