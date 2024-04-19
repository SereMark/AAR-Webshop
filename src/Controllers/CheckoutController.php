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
        //For now just show a notfound error
        header("HTTP/1.0 404 Not Found");
        require __DIR__ . '/../Views/notfound.php';
    }
}