<?php

$router = new Router();

$router->get('/', function ($router) {
    require __DIR__ . '/Views/home.php';
});

$router->get('/login', function ($router) {
    require __DIR__ . '/Views/login.php';
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

$router->setNotFoundHandler(function ($router) {
    header('HTTP/1.0 error Not Found');
    require __DIR__ . '/../../Views/error.php';
});

return $router;