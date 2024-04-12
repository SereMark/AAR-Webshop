<?php
class CartController {
    private $cartModel;

    /**
     * Constructs the CartController and initializes the CartModel.
     */
    public function __construct() {
        require_once __DIR__ . '/../Models/CartModel.php';
        $this->cartModel = new CartModel();
    }

    /**
     * Displays the cart page for the logged-in user.
     */
    public function showCart() {
        // Start the session to ensure access to session variables
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['userid'] ?? null;

        // Redirect to the home page if the user is not logged in
        if (!$userId) {
            header("Location: /");
            exit;
        }

        // Retrieve the cart items for the user from the model
        $cartItems = $this->cartModel->getCartItemsByUserId($userId);

        // Pass the cart items to the cart view for rendering
        $content = __DIR__ . '/../Views/cart.php';
        require __DIR__ . '/../Views/layout.php';
    }

    /**
     * Adds an item to the cart for the logged-in user.
     */
    public function addItemToCart() {
        // Start the session to ensure access to session variables
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['userid'] ?? null;

        // Redirect to the home page if the user is not logged in
        if (!$userId) {
            header("Location: /");
            exit;
        }

        // Get the product ID from the POST data
        $productId = $_POST['productid'] ?? null;

        // Add the item to the cart using the model
        $success = $this->cartModel->addItemToCart($userId, $productId);

        // Redirect to the cart page after adding the item
        header("Location: /api/cart");
        exit;
    }
}