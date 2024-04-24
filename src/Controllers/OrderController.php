<?php
require_once 'BaseController.php';

class OrderController extends BaseController {
    private $OrderModel;

    /**
     * OrderController constructor
     * Initializes OrderModel
     */
    public function __construct() {
        parent::__construct();
        $this->OrderModel = $this->loadModel('Order');
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
    
        $pageTitle = 'Orders';
        $content = __DIR__ . '/../Views/ordersList.php';
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
}