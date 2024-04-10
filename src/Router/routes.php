<?php
$router = new Router();

$router->get('/', function () {
    $content = __DIR__ . '/../Views/products.php';
    require __DIR__ . '/../Views/layout.php';
});

$router->get('/api/login', function () {
    $content = __DIR__ . '/../Views/login.php';
    require __DIR__ . '/../Views/layout.php';
});

$router->get('/api/register', function () {
    $content = __DIR__ . '/../Views/register.php';
    require __DIR__ . '/../Views/layout.php';
});

$router->get('/api/check-db-connection', function () {
    header('Content-Type: application/json');
    echo json_encode(['connected' => isDatabaseConnected()]);
    exit;
});

$router->setNotFoundHandler(function ($router) {
    header('HTTP/1.0 error Not Found');
    require __DIR__ . '/../Views/error.php';
});

return $router;