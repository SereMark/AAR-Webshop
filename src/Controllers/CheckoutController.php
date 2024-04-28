<?php
require_once 'BaseController.php';

class CheckoutController extends BaseController {
    private $checkoutModel;

    /**
     * Constructor: Initializes Checkout model
     */
    public function __construct() {
        parent::__construct();
        $this->checkoutModel = $this->loadModel('Checkout');
    }

    public function showCheckout() {
        $this->ensureLoggedIn();
        $userId = $_SESSION['userid'];
        $content = __DIR__ . '/../Views/checkout.php';
        $pageTitle = 'Checkout';
        require __DIR__ . '/../Views/layout.php';
    }
}