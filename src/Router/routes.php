<?php
require_once __DIR__ . '/../Helpers/RouterUtils.php';
$router = new Router();

// Product related routes
$router->get('/', fn() => controller('Products')->displayProducts());
$router->get('/product', fn() => controller('Products')->showProductById());
$router->post('/add-product', fn() => controller('Products')->addProduct());
$router->get('/products', fn() => controller('Products')->showUserProducts());
$router->post('/delete-product', fn() => controller('Products')->deleteProduct());
$router->post('/delete-all-products', fn() => controller('Products')->deleteAllUserProducts());

// Category related routes
$router->post('/add-category', fn() => controller('Categories')->addCategory());
$router->post('/delete-category', fn() => controller('Categories')->deleteCategory());

// User related routes
$router->get('/profile', fn() => controller('User')->showProfile());
$router->get('/logout', fn() => controller('User')->logout());
$router->get('/delete-profile', fn() => controller('User')->deleteProfile());
$router->post('/delete-profile', fn() => controller('User')->deleteOne());
$router->post('/edit-profile', fn() => controller('User')->updateProfile());
$router->post('/change-password', fn() => controller('User')->updatePassword());
$router->post('/change-balance', fn() => controller('User')->updateBalance());
$router->get('/admin_dashboard', fn() => controller('User')->showAdminDashboard());
$router->post('/set-admin-status', fn() => controller('User')->setAdminStatus());

// Authentication related routes
$router->post('/login', fn() => controller('Login')->login());
$router->post('/register', fn() => controller('Registration')->register());

// Cart related routes
$router->get('/cart', fn() => controller('Cart')->showCart());
$router->post('/cart', fn() => controller('Cart')->addItemToCart());
$router->post('/cart/update', fn() => controller('Cart')->updateItemQuantity());
$router->post('/cart/delete', fn() => controller('Cart')->deleteItemFromCart());
$router->post('/checkout', fn() => controller('Order')->showCheckout());

// Review related routes
$router->post('/submit-review', fn() => controller('Reviews')->submitReview());
$router->post('/delete-review', fn() => controller('Reviews')->deleteUserReview());
$router->post('/delete-specific-review', fn() => controller('Reviews')->deleteSpecificReview());
$router->get('/reviews', fn() => controller('Reviews')->showUserReviews());
$router->post('/delete-all-reviews', fn() => controller('Reviews')->deleteAllUserReviews());

// Order related routes
$router->get('/orders', fn() => controller('Order')->showUserOrders());
$router->post('/delete-order', fn() => controller('Order')->deleteOrder());
$router->post('/order-details', fn() => controller('Order')->showUserOrderReview());
$router->get('/order-details', fn() => controller('Order')->showUserOrderReview());
$router->post('/order-details/orderFeedback', fn() => controller('Order')->placeOrder());
$router->post('/mark-as-paid', fn() => controller('Order')->markAsPaid());
$router->post('/mark-as-delivered', fn() => controller('Order')->markAsDelivered());

// Coupon related routes
$router->post('/add-coupon', fn() => controller('Coupon')->addCoupon());
$router->post('/delete-coupon', fn() => controller('Coupon')->deleteCoupon());

// System related routes
$router->get('/check-db-connection', fn() => controller('System')->checkDatabaseConnection());

// Error handling
$router->setNotFoundHandler(fn() => controller('Error')->showNotFound());

return $router;