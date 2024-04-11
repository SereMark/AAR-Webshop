<?php
$router = new Router();

$router->get('/', function () {
    $pageTitle = "Products";
    $content = __DIR__ . '/../Views/products.php';
    require __DIR__ . '/../Views/layout.php';
});

$router->get('/api/login', function () {
    $content = __DIR__ . '/../Views/login.php';
    require __DIR__ . '/../Views/layout.php';
});

$router->post('/api/login', function () {
    $controller = new LoginController();
    $controller->login();
});

$router->get('/api/register', function () {
    $content = __DIR__ . '/../Views/register.php';
    require __DIR__ . '/../Views/layout.php';
});

$router->post('/api/register', function () {
    $controller = new RegistrationController();
    $controller->register();
});

$router->get('/api/profile', function () {
    $pageTitle = "Profile";
    $content = __DIR__ . '/../Views/profile.php';
    require __DIR__ . '/../Views/layout.php';
});

$router->get('/api/logout', function() {
    $controller = new UserController();
    $controller->logout();
});

$router->get('/api/delete-profile', function() {
    $controller = new UserController();
    $controller->deleteProfile();
});

$router->get('/api/check-db-connection', function () {
    header('Content-Type: application/json');
    echo json_encode(['connected' => isDatabaseConnected()]);
    exit;
});

$router->setNotFoundHandler(function ($router) {
    header('HTTP/1.0 error Not Found');
    require __DIR__ . '/../Views/notfound.php';
});

return $router;