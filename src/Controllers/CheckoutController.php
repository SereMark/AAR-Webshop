<?php
require_once 'BaseController.php';

class CheckoutController extends BaseController {
    /**
     * Processes the checkout action for the logged-in user.
     */
    public function processCheckout() {
        // TODO: Implement actual checkout logic

        header("HTTP/1.0 404 Not Found");
        require __DIR__ . '/../Views/notfound.php';
    }
}