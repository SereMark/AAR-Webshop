<?php
require_once 'BaseController.php';

class CartController extends BaseController {
    private $cartModel;

    /**
     * Constructor: Initializes Cart model
     */
    public function __construct() {
        parent::__construct();
        $this->cartModel = $this->loadModel('Cart');
    }

    /**
     * Displays cart
     */
    public function showCart() {
        $this->ensureLoggedIn();
        $userId = $_SESSION['userid'];
        $cartItems = $this->cartModel->getCartItemsByUserId($userId);
        $content = __DIR__ . '/../Views/cart.php';
        $pageTitle = 'Cart';
        require __DIR__ . '/../Views/layout.php';
    }

    /**
     * Adds item to cart
     */
    public function addItemToCart() {
        $this->ensureLoggedIn();
        $userId = $_SESSION['userid'];
        $productId = $_POST['productid'] ?? null;
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        if ($productId && $quantity > 0) {
            $result = $this->cartModel->addItemToCart($userId, $productId, $quantity);
            if ($result) {
                $this->redirect('/cart?info=cartAdd');
            } else {
                $this->redirect('/cart?info=error');
            }
        } else {
            $this->redirect('/cart?info=error');
        }
    }

    /**
     * Updates quantity of an item in the cart
     */
    public function updateItemQuantity() {
        $this->ensureLoggedIn();
        $cartItemId = $_POST['cartitemid'] ?? null;
        $newQuantity = $_POST['quantity'] ?? null;

        if ($cartItemId && $newQuantity > 0) {
            $result = $this->cartModel->updateCartItemQuantity($cartItemId, $newQuantity);
            if ($result) {
                $this->redirect('/cart?info=update');
            } else {
                $this->redirect('/cart?info=error');
            }
        } else {
            $this->redirect('/cart?info=error');
        }
    }

    /**
     * Deletes item from cart
     */
    public function deleteItemFromCart() {
        $this->ensureLoggedIn();
        $cartItemId = $_POST['cartitemid'] ?? null;
        if ($cartItemId && $this->cartModel->removeItemFromCart($cartItemId)) {
            $this->redirect('/cart?info=cartRemove');
        } else {
            $this->redirect('/cart?info=error');
        }
    }
}