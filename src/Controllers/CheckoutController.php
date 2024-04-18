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
}