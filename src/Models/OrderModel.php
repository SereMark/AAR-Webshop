<?php
require_once __DIR__ . '/../Helpers/db.php';

/**
 * Class OrderModel
 * Handles order-related database operations
 */
class OrderModel
{

    /**
     * Fetch all orders for a specific user by their ID
     * @param int $userId
     * @return array - Array of orders
     * @throws Exception
     */
    public function fetchOrdersByUserId(int $userId)
    {
        $conn = getDatabaseConnection();
        $sql = 'SELECT * FROM orders WHERE userid = :userid ORDER BY orderid DESC';
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ':userid', $userId, -1, SQLT_INT);

        if (!oci_execute($stmt)) {
            oci_free_statement($stmt);
            oci_close($conn);
            throw new Exception("Fetching orders execution error");
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
     * @throws Exception
     */
    public function getOrderCountByUserId(int $userId)
    {
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
     * @throws Exception
     */
    public function fetchAllOrders(): array
    {
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
     * Fetch all orders from the database
     * @return array - Array of orders
     * @throws Exception
     */
    public function fetchLastInsertedOrder(): array
    {
        $conn = getDatabaseConnection();
        $sql = 'SELECT *
                FROM orders
                ORDER BY orderid DESC
                FETCH FIRST 1 ROW ONLY';
        $stmt = oci_parse($conn, $sql);

        oci_execute($stmt);

        $lastOrder = [];
        while ($row = oci_fetch_array($stmt, OCI_ASSOC)) {
            $lastOrder[] = $row;
        }

        oci_free_statement($stmt);
        oci_close($conn);
        return $lastOrder;
    }

    /**
     * Fetch an order by its ID
     * @param int $orderId
     * @return array|bool - Order details or false if not found
     * @throws Exception
     */
    public function deleteOrderById(int $orderId): bool
    {
        $conn = getDatabaseConnection();
        try {
            // Delete order items first (using PDO for clarity)
            $sql = "DELETE FROM ORDERITEMS WHERE ORDERID = :orderId";
            $stmt = oci_parse($conn, $sql);
            oci_bind_by_name($stmt, ':orderid', $orderId);

            if (!oci_execute($stmt)) {
                $error = oci_error($stmt);
                oci_free_statement($stmt);
                throw new Exception("Failed to delete order: " . $error['message']);
            }

            // Delete the order
            $sql = 'DELETE FROM orders WHERE orderid = :orderid';
            $stmt = oci_parse($conn, $sql);
            oci_bind_by_name($stmt, ':orderid', $orderId);

            if (!oci_execute($stmt)) {
                $error = oci_error($stmt);
                oci_free_statement($stmt);
                throw new Exception("Failed to delete order: " . $error['message']);
            }
            return true;
        } catch (Exception $e) {
            throw new Exception("Failed to delete order: " . $e->getMessage());
        } finally {
            oci_close($conn); // Ensure connection is closed even on exceptions
        }

    }


    /**
     * @throws Exception
     */
    public function createOrder(int $userId, array $cartItems, string $totalAmount, string $zipcode, string $city, string $address, string $paymentType): bool
    {
        try {
            $conn = getDatabaseConnection();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        try {
            $sql = 'INSERT INTO orders (userid, totalamount, paymentmethod, zipcode, city, address) VALUES(:userid, :total_amount, :payment_type, :zipcode, :city, :address)';
            $stmt = oci_parse($conn, $sql);
            oci_bind_by_name($stmt, ':userid', $userId);
            oci_bind_by_name($stmt, ':zipcode', $zipcode);
            oci_bind_by_name($stmt, ':city', $city);
            oci_bind_by_name($stmt, ':address', $address);
            oci_bind_by_name($stmt, ':payment_type', $paymentType);
            oci_bind_by_name($stmt, ':total_amount', $totalAmount);

            if (!oci_execute($stmt)) {
                oci_rollback($conn);
                oci_free_statement($stmt);
                oci_close($conn);
                throw new Exception("Failed to create order!");
            }

            oci_free_statement($stmt);

            $lastInsertedOrder = $this->fetchLastInsertedOrder();

            $this->insertIntoCartitems($cartItems, $conn, $lastInsertedOrder);
        } catch (Exception $e) {
            oci_rollback($conn); // Rollback if any exception occurs
            throw new Exception($e->getMessage());
        }

        oci_close($conn);
        return true; // Order creation successful

    }

    /**
     * @param array $cartItems
     * @param $conn
     * @param array $orderId
     * @return bool
     * @throws Exception
     */
    public function insertIntoCartitems(array $cartItems, $conn, array $lastInsertedOrder): bool
    {
        if ($lastInsertedOrder && $cartItems) {
            $orderId = $lastInsertedOrder[0]["ORDERID"];
            try {
                foreach ($cartItems as $cartItem) {
                    $totalItemPrice = $cartItem['price'] * $cartItem['quantity'];
                    /*echo $orderIdValue . ' - ' . $cartItem['productid'] . ' - ' . $cartItem['quantity'] . ' - ' . $totalItemPrice;*/

                    $sql = 'INSERT INTO ORDERITEMS (ORDERID, PRODUCTID, QUANTITY, PRICE) VALUES (:orderid, :productid, :quantity, :price)';
                    $stmt = oci_parse($conn, $sql);
                    oci_bind_by_name($stmt, ':orderid', $orderId);
                    oci_bind_by_name($stmt, ':productid', $cartItem['productid']);
                    oci_bind_by_name($stmt, ':quantity', $cartItem['quantity']);
                    oci_bind_by_name($stmt, ':price', $totalItemPrice);

                    if (!oci_execute($stmt)) {
                        oci_rollback($conn);
                        oci_free_statement($stmt);
                        oci_close($conn);
                        throw new Exception("Failed to save order items!");
                    }
                    oci_free_statement($stmt);
                    $this->deleteCartItems();
                }
            } catch (Exception $e) {
                oci_rollback($conn); // Rollback if any exception occurs
                throw new Exception($e->getMessage());
            }
            return true;
        }
        return false;
    }

    private function deleteCartItems() {

    }


}