<?php
require_once 'BaseController.php';

class CouponController extends BaseController {
    private $couponsModel;

    /**
     * Constructor initializes the Models.
     */
    public function __construct() {
        parent::__construct();
        $this->couponsModel = $this->loadModel('Coupons');
    }

    public function addCoupon() {
        $this->ensureLoggedIn();
        $couponCode = $_POST['couponCode'] ?? null;
        $couponDiscount = $_POST['discount'] ?? null;

        // Check if either coupon code or discount is missing.
        if (!$couponCode || !$couponDiscount) {
            error_log("Coupon code or discount is missing");
            $this->redirect('/?info=error');
            return; // Return after redirect to prevent further execution
        }

        // Redirect if discount is numeric (assuming here you want numeric values, reverse if necessary).
        if (!is_numeric($couponDiscount)) {
            error_log("Discount is not numeric");
            $this->redirect('/admin_dashboard?info=numberError');
            return; // Return after redirect
        }

        // Check for existing coupon code before adding.
        if ($this->couponsModel->couponExists($couponCode)) {
            error_log("Coupon code already exists");
            $this->redirect('/admin_dashboard?info=CodeAlreadyExists');
            return; // Return after redirect
        }

        // Attempt to add the coupon.
        try {
            $this->couponsModel->addCoupon($couponCode, $couponDiscount);
            $this->redirect('/admin_dashboard?info=couponAdded');
        } catch (Exception $e) {
            error_log("Error adding coupon: " . $e->getMessage());
            $this->redirect('/admin_dashboard?info=error');
        }
    }

    /**
     * Deletes a coupon.
     */
    public function deleteCoupon() {
        $this->ensureLoggedIn();
        $couponId = $_POST['couponid'] ?? null;
        if (!$couponId) {
            $this->redirect('/?info=error');
        }

        $this->couponsModel->deleteCoupon($couponId);
        $this->redirect('/admin_dashboard?info=delete');
    }
}