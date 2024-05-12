<?php
require_once 'BaseController.php';
require_once 'fpdf.php';

class OrderController extends BaseController
{
    private $OrderModel;
    private $cartModel;
    private $usersModel;

    private $couponModel;

    /**
     * OrderController constructor
     * Initializes OrderModel
     */
    public function __construct()
    {
        parent::__construct();
        $this->OrderModel = $this->loadModel('Order');
        $this->cartModel = $this->loadModel('Cart');
        $this->usersModel = $this->loadModel('Users');
        $this->couponModel = $this->loadModel('Coupons');
    }

    public function showCheckout()
    {
        $this->ensureLoggedIn();
        $userId = $_SESSION['userid'];
        $content = __DIR__ . '/../Views/checkout.php';
        $pageTitle = 'Checkout';
        require __DIR__ . '/../Views/layout.php';
    }

    /**
     * Display all orders for a specific user by their ID
     */
    public function showUserOrders()
    {
        $userId = $_SESSION['userid'] ?? null;
        if (!$userId) {
            $this->redirect('/?info=LoginRequired');
        }

        $orders = $this->OrderModel->fetchOrdersByUserId($userId);
        foreach ($orders as &$order) {
            $order['items'] = $this->OrderModel->fetchOrderItemsByOrderId($order['ORDERID']);
            $order['blob'] = $this->OrderModel->getInvoiceBlob($order['ORDERID']);
            $order['blobFileName'] = 'invoice_' . $order['ORDERID'] . '.pdf';
            var_dump($this->OrderModel->getInvoiceBlob($order['ORDERID']));
        }


        $user = $this->usersModel->getUserDetailsById($userId);
        $pageTitle = 'Orders';
        $content = __DIR__ . '/../Views/ordersList.php';
        require __DIR__ . '/../Views/layout.php';
    }

    /**
     * Display the order details for a specific order by its ID
     */
    public function showUserOrderReview()
    {
        $this->ensureLoggedIn();
        $userId = $_SESSION['userid'];
        $cartItems = $this->cartModel->getCartItemsByUserId($userId);
        $coupons = $this->couponModel->fetchCoupons();

        $zipcode = $_POST['zipcode'] ?? 'N/A';
        $city = $_POST['city'] ?? 'N/A';
        $address = $_POST['address'] ?? 'N/A';
        $payment_type = $_POST['payment_type'] ?? 'N/A';
        $payment_type_value = "";
        $has_payment_value = $payment_type == "pod" || $payment_type == "card";
        if ($has_payment_value) {
            $payment_type_value = $payment_type == "pod" ? "Pay on delivery" : "Credit Card";
        }
        $user = $this->usersModel->getUserDetailsById($userId);

        $totalPrice = 0;
        $discountApplied = false; // Flag to indicate if any discount has been applied
        foreach ($cartItems as &$item) {
            $item['final_price'] = $item['price'] * $item['quantity'];
            $totalPrice += $item['final_price'];
        }

        if (!$discountApplied && isset($_POST['coupon'])) {
            foreach ($coupons as $coupon) {
                if ($coupon['CODE'] == $_POST['coupon']) {
                    $totalPrice *= (1 - ($coupon['DISCOUNT'] / 100));
                    $discountApplied = true; // Mark discount as applied
                    break; // Exit the loop as soon as a discount is applied
                }
            }
        }

        if (!$discountApplied && $totalPrice > 1000) { // Apply bulk discount if total exceeds $1000
            $totalPrice *= 0.8;
            $discountApplied = true; // Mark discount as applied
        }

        $content = __DIR__ . '/../Views/order_details.php';
        $pageTitle = 'Order Details';
        require __DIR__ . '/../Views/layout.php';
    }

    /**
     * Handles the deletion of an order by its ID
     */
    public function deleteOrder()
    {
        $orderId = $_POST['orderid'] ?? null;
        if ($orderId && $this->OrderModel->deleteOrderById($orderId)) {
            $this->redirect('/admin_dashboard?info=delete');
        } else {
            $this->redirect('/admin_dashboard?info=error');
        }
    }

    public function placeOrder()
    {
        $userId = $_SESSION['userid'] ?? null;

        $cartItems = $this->cartModel->getCartItemsByUserId($userId);
        $cartId = $this->cartModel->getOrCreateCartId($userId);
        $totalAmount = $_POST['total_amount'] ?? '';
        $zipcode = $_POST['zipcode'] ?? '';
        $city = $_POST['city'] ?? '';
        $address = $_POST['address'] ?? '';
        $paymentType = $_POST['payment_type'] ?? '';
        $blob = $_POST['blobUrl'] ?? null;

        $orderModel = new OrderModel();


        try {
            if ($orderModel->createOrder($userId, $cartItems, $totalAmount, $zipcode, $city, $address, $paymentType)) {
                // Order creation successful, redirect or display confirmation
                //echo "Order placed successfully!";
                if ($this->removeOrderedCartItems($cartItems)) {
                    try {
                        $this->cartModel->removeCartById($cartId);
                    } catch (Exception $e) {
                        echo "Error removing cart with cartid " . $cartId . ": " . $e->getMessage();
                    }
                    $lastOrder = $orderModel->fetchLastInsertedOrderByUser($userId);
                    $orderId = $lastOrder['ORDERID'];
                    $this->OrderModel->insertInvoiceBlob($orderId, $blob);
                } else {
                    echo "Some cart items failed to be removed. Cart not removed.";
                }
            } else {
                // Handle order creation failure
                echo "Failed to place order. Please try again.";
            }
        } catch (Exception $e) {
            // Handle any exceptions that might occur during order processing
            echo "Error: " . $e->getMessage();
        }
        $this->redirect('/?info=orderInserted');
    }

    public function removeOrderedCartItems($cartItems): bool
    {
        $removedAllItems = true;
        foreach ($cartItems as $cartItem) {
            try {
                $this->cartModel->removeItemFromCart($cartItem['cartitemid']);
            } catch (Exception $e) {
                echo "Error removing item with cartitemid " . $cartItem['cartitemid'] . ": " . $e->getMessage();
                $removedAllItems = false; // Set to false on any removal error
            }
        }
        return $removedAllItems;
    }


    public function markAsPaid()
    {
        $orderId = $_POST['orderid'] ?? null;
        if (!$orderId) {
            $this->redirect('/admin_dashboard?info=error');
        }

        if ($this->OrderModel->updateOrderPaidStatus($orderId, 'Y')) {
            $this->redirect('/admin_dashboard?info=Success');
        } else {
            $this->redirect('/admin_dashboard?info=error');
        }
    }

    public function markAsDelivered() {
        $orderId = $_POST['orderid'] ?? null;
        if (!$orderId) {
            $this->redirect('/admin_dashboard?info=error');
        }
    
        if ($this->OrderModel->updateOrderDeliveredStatus($orderId)) {
            $this->redirect('/admin_dashboard?info=Success');
        } else {
            $this->redirect('/admin_dashboard?info=error');
        }
    }
}