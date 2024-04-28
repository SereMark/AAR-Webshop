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
$router->get('/products', function () {
    $controller = new ProductsController();
    $controller->showUserProducts();
});
$router->post('/delete-product', function () {
    $controller = new ProductsController();
    $controller->deleteProduct();
});
$router->post('/delete-all-products', function () {
    $controller = new ProductsController();
    $controller->deleteAllUserProducts();
});

// Category related routes
$router->post('/add-category', function() {
    $controller = new CategoriesController();
    $controller->addCategory();
});
$router->post('/delete-category', function() {
    $controller = new CategoriesController();
    $controller->deleteCategory();
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
$router->post('/delete-profile', function() {
    $controller = new UserController();
    $controller->deleteOne();
});
$router->post('/edit-profile', function() {
    $controller = new UserController();
    $controller->updateProfile();
});
$router->post('/change-password', function() {
    $controller = new UserController();
    $controller->updatePassword();
});
$router->get('/admin_dashboard', function () {
    $controller = new UserController();
    $controller->showAdminDashboard();
});
$router->post('/set-admin-status', function () {
    $controller = new UserController();
    $controller->setAdminStatus();
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
$router->post('/cart/update', function () {
    $controller = new CartController();
    $controller->updateItemQuantity();
});
$router->post('/cart/delete', function() {
    $controller = new CartController();
    $controller->deleteItemFromCart();
});
$router->post('/checkout', function () {
    $controller = new CheckoutController();
    $controller->showCheckout();
});

// Review related routes
$router->post('/submit-review', function () {
    $controller = new ReviewsController();
    $controller->submitReview();
});
$router->post('/delete-review', function () {
    $controller = new ReviewsController();
    $controller->deleteUserReview();
});
$router->post('/delete-specific-review', function() {
    $controller = new ReviewsController();
    $controller->deleteSpecificReview();
});
$router->get('/reviews', function () {
    $controller = new ReviewsController();
    $controller->showUserReviews();
});
$router->post('/delete-all-reviews', function () {
    $controller = new ReviewsController();
    $controller->deleteAllUserReviews();
});

// Order related routes
$router->get('/orders', function () {
    $controller = new OrderController();
    $controller->showUserOrders();
});
$router->post('/delete-order', function() {
    $controller = new OrderController();
    $controller->deleteOrder();
});
$router->post('/order-details', function() {
    $controller = new OrderController();
    $controller->showUserOrderReview();
});
$router->post('/order-details/orderFeedback', function() {
    $controller = new OrderController();
    $controller->placeOrder();
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