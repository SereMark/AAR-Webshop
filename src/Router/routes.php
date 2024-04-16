<?php
$router = new Router();

// Product related routes
$router->get('/', function () {
    $controller = new ProductsController();
    $controller->index();
});
$router->get('/product', function () {
    $controller = new ProductsController();
    $controller->showProductById();
});
$router->post('/add-product', function () {
    $controller = new ProductsController();
    $controller->addProduct();
});

// User related routes
$router->get('/profile', function () {
    $controller = new UserController();
    $controller->showProfile();
});
$router->get('/logout', function() {
    $controller = new UserController();
    $controller->logout();
});
$router->get('/delete-profile', function() {
    $controller = new UserController();
    $controller->deleteProfile();
});

// Authentication related routes
$router->post('/login', function () {
    $controller = new LoginController();
    $controller->login();
});
$router->post('/register', function () {
    $controller = new RegistrationController();
    $controller->register();
});

// Cart related routes
$router->get('/cart', function () {
    $controller = new CartController();
    $controller->showCart();
});
$router->post('/cart', function () {
    $controller = new CartController();
    $controller->addItemToCart();
});
$router->post('/cart/delete', function() {
    $controller = new CartController();
    $controller->deleteItemFromCart();
});
$router->post('/checkout', function () {
    $controller = new CheckoutController();
    $controller->processCheckout();
});

// Review related routes
$router->post('/submit-review', function () {
    $controller = new ReviewsController();
    $controller->submitReview();
});
$router->post('/delete-review', function () {
    $controller = new ReviewsController();
    $controller->deleteReview();
});

// System related routes
$router->get('/check-db-connection', function () {
    $controller = new SystemController();
    $controller->checkDatabaseConnection();
});

// Error handling
$router->setNotFoundHandler(function () {
    $controller = new ErrorController();
    $controller->showNotFound();
});

return $router;