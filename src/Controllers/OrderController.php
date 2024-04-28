<?php
require_once 'BaseController.php';

class OrderController extends BaseController {
    private $OrderModel;
    private $cartModel;
    private $usersModel;

    /**
     * OrderController constructor
     * Initializes OrderModel
     */
    public function __construct() {
        parent::__construct();
        $this->OrderModel = $this->loadModel('Order');
        $this->cartModel = $this->loadModel('Cart');
        $this->usersModel = $this->loadModel('Users');
    }

    /**
     * Display all orders for a specific user by their ID
     */
    public function showUserOrders() {
        $userId = $_SESSION['userid'] ?? null;
        if (!$userId) {
            $this->redirect('/?info=LoginRequired');
        }

        $orderItems = $this->OrderModel->fetchOrdersByUserId($userId);
        $user = $this->usersModel->getUserDetailsById($userId);

        $pageTitle = 'Orders';
        $content = __DIR__ . '/../Views/ordersList.php';
        require __DIR__ . '/../Views/layout.php';
    }
    /**
     * Display actual order details
     */
    public function showUserOrderReview() {
            $this->ensureLoggedIn();
            $userId = $_SESSION['userid'];
            $cartItems = $this->cartModel->getCartItemsByUserId($userId);
            $content = __DIR__ . '/../Views/order_details.php';
            $pageTitle = 'Order details';
            require __DIR__ . '/../Views/layout.php';
    }

    /**
     * Handles the deletion of an order by its ID
     */
    public function deleteOrder() {
        $orderId = $_POST['orderid'] ?? null;
        if ($orderId && $this->OrderModel->deleteOrderById($orderId)) {
            $this->redirect('/admin_dashboard?info=delete');
        } else {
            $this->redirect('/admin_dashboard?info=error');
        }
    }

    public function placeOrder() {
        $userId = $_SESSION['userid'] ?? null;

        $cartItems = $this->cartModel->getCartItemsByUserId($userId);
        $cartId = $this->cartModel->getOrCreateCartId($userId);
        $totalAmount = $_POST['total_amount'] ?? '';
        $zipcode = $_POST['zipcode'] ?? '';
        $city = $_POST['city'] ?? '';
        $address = $_POST['address'] ?? '';
        $paymentType = $_POST['payment_type'] ?? '';

        $orderModel = new OrderModel();


        try {
            if ($orderModel->createOrder($userId, $cartItems, $totalAmount, $zipcode, $city, $address, $paymentType)) {
                // Order creation successful, redirect or display confirmation
                echo "Order placed successfully!";
                $removedAllItems = true;
                foreach ($cartItems as $cartItem) {
                    try {
                        $this->cartModel->removeItemFromCart($cartItem['cartitemid']);
                    } catch (Exception $e) {
                        echo "Error removing item with cartitemid " . $cartItem['cartitemid'] . ": " . $e->getMessage();
                        $removedAllItems = false; // Set to false on any removal error
                    }
                }

                if ($removedAllItems) {
                    try {
                        $this->cartModel->removeCartById($cartId);
                    } catch (Exception $e) {
                        echo "Error removing cart with cartid " . $cartId . ": " . $e->getMessage();
                    }
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


}