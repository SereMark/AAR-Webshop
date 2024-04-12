<?php
// Create a new Router instance
$router = new Router();

// Define a GET route for the homepage
$router->get('/', function () {
    // Set the page title and content
    $pageTitle = "Products";
    $content = __DIR__ . '/../Views/products.php';
    // Include the layout view
    require __DIR__ . '/../Views/layout.php';
});

// Define a GET route for the login page
$router->get('/api/login', function () {
    // Set the content
    $content = __DIR__ . '/../Views/login.php';
    // Include the layout view
    require __DIR__ . '/../Views/layout.php';
});

// Define a POST route for the login action
$router->post('/api/login', function () {
    // Create a new LoginController instance and call the login method
    $controller = new LoginController();
    $controller->login();
});

// Define a GET route for the registration page
$router->get('/api/register', function () {
    // Set the content
    $content = __DIR__ . '/../Views/register.php';
    // Include the layout view
    require __DIR__ . '/../Views/layout.php';
});

// Define a POST route for the registration action
$router->post('/api/register', function () {
    // Create a new RegistrationController instance and call the register method
    $controller = new RegistrationController();
    $controller->register();
});

// Define a GET route for the profile page
$router->get('/api/profile', function () {
    // Set the page title and content
    $pageTitle = "Profile";
    $content = __DIR__ . '/../Views/profile.php';
    // Include the layout view
    require __DIR__ . '/../Views/layout.php';
});

// Define a GET route for the cart page
$router->get('/api/cart', function () {
    // Set the page title and content
    $pageTitle = "Cart";
    $content = __DIR__ . '/../Views/cart.php';
    // Include the layout view
    require __DIR__ . '/../Views/layout.php';
});

// Define a GET route for the logout action
$router->get('/api/logout', function() {
    // Create a new UserController instance and call the logout method
    $controller = new UserController();
    $controller->logout();
});

// Define a GET route for the delete profile action
$router->get('/api/delete-profile', function() {
    // Create a new UserController instance and call the deleteProfile method
    $controller = new UserController();
    $controller->deleteProfile();
});

// Define a GET route for checking the database connection
$router->get('/api/check-db-connection', function () {
    // Set the content type to JSON
    header('Content-Type: application/json');
    // Output a JSON object with a property indicating whether the database is connected
    echo json_encode(['connected' => isDatabaseConnected()]);
    // End the script
    exit;
});

// Set the not found handler
$router->setNotFoundHandler(function ($router) {
    // Send a 404 Not Found response
    header('HTTP/1.0 error Not Found');
    // Include the not found view
    require __DIR__ . '/../Views/notfound.php';
});

// Return the router instance
return $router;