<?php
// Create a new Router instance
$router = new Router();

// Define a GET route for the homepage
$router->get('/', function () {
    $controller = new ProductsController();
    $controller->index();
});

// Define a POST route for the login action
$router->post('/api/login', function () {
    $controller = new LoginController();
    $controller->login();
});

// Define a POST route for the registration action
$router->post('/api/register', function () {
    $controller = new RegistrationController();
    $controller->register();
});

// Define a GET route for the profile page
$router->get('/api/profile', function () {
    $controller = new UserController();
    $controller->showProfile();
});

// Define a GET route for the cart page
$router->get('/api/cart', function () {
    $controller = new CartController();
    $controller->showCart();
});

// Define a POST route for adding an item to the cart
$router->post('/api/cart', function () {
    $controller = new CartController();
    $controller->addItemToCart();
});

// Define a POST route for deleting an item from the cart
$router->post('/api/cart/delete', function() {
    $controller = new CartController();
    $controller->deleteItemFromCart();
});

// Define a POST route for the checkout action
$router->post('/api/checkout', function () {
    $controller = new CheckoutController();
    $controller->processCheckout();
});

// Define a GET route for the logout action
$router->get('/api/logout', function() {
    $controller = new UserController();
    $controller->logout();
});

// Define a GET route for the delete profile action
$router->get('/api/delete-profile', function() {
    $controller = new UserController();
    $controller->deleteProfile();
});

// Define a GET route for product details
$router->get('/api/product', function () {
    $controller = new ProductsController();
    $controller->showProductById();
});

// Handle adding new product
$router->post('/api/add-product', function () {
    $controller = new ProductsController();
    $controller->addProduct();
});

// Define a POST route for submitting a review
$router->post('/api/submit-review', function () {
    $controller = new ReviewsController();
    $controller->submitReview();
});

// Define a POST route for deleting a review
$router->post('/api/delete-review', function () {
    $controller = new ReviewsController();
    $controller->deleteReview();
});

// Define a GET route for checking the database connection
$router->get('/api/check-db-connection', function () {
    $controller = new SystemController();
    $controller->checkDatabaseConnection();
});

// Set the not found handler
$router->setNotFoundHandler(function () {
    $controller = new ErrorController();
    $controller->showNotFound();
});

// Return the router instance
return $router;
