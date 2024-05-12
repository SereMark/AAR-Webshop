<?php
require_once 'BaseController.php';

class CouponController extends BaseController
{
    private $couponsModel;

    /**
     * Constructor initializes the Models.
     */
    public function __construct()
    {
        parent::__construct();
        $this->couponsModel = $this->loadModel('Coupons');
    }

    public function addCoupon()
    {
        $this->ensureLoggedIn();

        // Retrieve input data
        $couponCode = $_POST['couponCode'] ?? null;
        $couponDiscount = $_POST['discount'] ?? null;

        // Validate coupon code
        if (empty(trim($couponCode))) {
            $this->redirect('/admin_dashboard?info=codeError');
            return;
        }

        if (strlen($couponCode) > 255) {
            $this->redirect('/admin_dashboard?info=codeLengthError');
            return;
        }

        // Validate discount
        if (!is_numeric($couponDiscount)) {
            $this->redirect('/admin_dashboard?info=numberError');
            return;
        }

        $couponDiscount = floatval($couponDiscount);
        if ($couponDiscount >= 1000 || $couponDiscount < 0) {
            $this->redirect('/admin_dashboard?info=discountRangeError');
            return;
        }

        // Check for more than two decimal places
        if (floor($couponDiscount * 100) != $couponDiscount * 100) {
            $this->redirect('/admin_dashboard?info=decimalError');
            return;
        }

        // Check for existing coupon code
        if ($this->couponsModel->couponExists($couponCode)) {
            $this->redirect('/admin_dashboard?info=CodeAlreadyExists');
            return;
        }

        // Attempt to add the coupon to the database
        try {
            $this->couponsModel->addCoupon($couponCode, $couponDiscount);
            $this->redirect('/admin_dashboard?info=couponAdded');
        } catch (Exception) {
            $this->redirect('/admin_dashboard?info=error');
        }
    }

    /**
     * Deletes a coupon.
     */
    public function deleteCoupon()
    {
        $this->ensureLoggedIn();
        $couponId = $_POST['couponid'] ?? null;
        if (!$couponId) {
            $this->redirect('/?info=error');
        }

        $this->couponsModel->deleteCoupon($couponId);
        $this->redirect('/admin_dashboard?info=delete');
    }
}