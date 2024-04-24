<?php
require_once __DIR__ . '/../Helpers/db.php';

/**
 * Class OrderModel
 * Handles order-related database operations
 */
class OrderModel {

    /**
     * Fetch all orders for a specific user by their ID
     * @param int $userId
     * @return array - Array of orders
     */
    public function fetchOrdersByUserId($userId) {
        $conn = getDatabaseConnection();
        $sql = 'SELECT * FROM orders WHERE userid = :userid ORDER BY orderid DESC';
        $stmt = oci_parse($conn, $sql);
    
        oci_bind_by_name($stmt, ':userid', $userId, -1, SQLT_INT);
    
        if (!oci_execute($stmt)) {
            oci_free_statement($stmt);
            oci_close($conn);
            return false;
        }
    
        $orders = [];
        while (($row = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) !== false) {
            $orders[] = $row;
        }
    
        oci_free_statement($stmt);
        oci_close($conn);
        return $orders;
    }

    /**
     * Fetch the count of orders for a specific user by their ID
     * @param int $userId
     * @return int - Count of orders
     */
    public function getOrderCountByUserId($userId) {
        $conn = getDatabaseConnection();
        $sql = 'SELECT COUNT(*) AS order_count FROM orders WHERE userid = :userid';
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ':userid', $userId, -1, SQLT_INT);

        if (!oci_execute($stmt)) {
            oci_free_statement($stmt);
            oci_close($conn);
            return 0;
        }

        $row = oci_fetch_array($stmt, OCI_ASSOC);
        $count = $row['ORDER_COUNT'] ?? 0;

        oci_free_statement($stmt);
        oci_close($conn);
        return $count;
    }

    /**
     * Fetch all orders from the database
     * @return array - Array of orders
     */
    public function fetchAllOrders() {
        $conn = getDatabaseConnection();
        $sql = 'SELECT * FROM orders ORDER BY orderid DESC';
        $stmt = oci_parse($conn, $sql);
        
        oci_execute($stmt);
        
        $orders = [];
        while ($row = oci_fetch_array($stmt, OCI_ASSOC)) {
            $orders[] = $row;
        }
        
        oci_free_statement($stmt);
        oci_close($conn);
        return $orders;
    }

    /**
     * Fetch an order by its ID
     * @param int $orderId
     * @return array|bool - Order details or false if not found
     */
    public function deleteOrderById($orderId) {
        $conn = getDatabaseConnection();
        $sql = 'DELETE FROM orders WHERE orderid = :orderid';
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':orderid', $orderId);
        
        if (!oci_execute($stmt)) {
            $error = oci_error($stmt);
            oci_free_statement($stmt);
            oci_close($conn);
            throw new Exception("Failed to delete order: " . $error['message']);
            return false;
        }
        
        oci_free_statement($stmt);
        oci_close($conn);
        return true;
    }    
}