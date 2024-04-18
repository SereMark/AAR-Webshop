<?php
require_once 'BaseController.php';

class CartController extends BaseController {
    private $cartModel;

    public function __construct() {
        parent::__construct();
        $this->cartModel = $this->loadModel('Cart');
    }

    public function showCart() {
        $this->ensureLoggedIn();
        $userId = $_SESSION['userid'];
        $cartItems = $this->cartModel->getCartItemsByUserId($userId);
        $content = __DIR__ . '/../Views/cart.php';
        $pageTitle = 'Cart';
        require __DIR__ . '/../Views/layout.php';
    }

    public function addItemToCart() {
        $this->ensureLoggedIn();
        $userId = $_SESSION['userid'];
        $productId = $_POST['productid'] ?? null;
        $this->cartModel->addItemToCart($userId, $productId);
        $this->redirect('/cart?info=cartAdd');
    }

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