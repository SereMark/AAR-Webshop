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
     * Fetch all order items for a specific order by its ID
     * @param int $orderId
     * @return array - Array of order items
     * @throws Exception
     */
    public function fetchOrderItemsByOrderId(int $orderId) {
        $conn = getDatabaseConnection();
        $sql = 'SELECT oi.orderid, oi.productid, oi.quantity, oi.price, p.name
                FROM orderitems oi
                JOIN products p ON p.productid = oi.productid
                WHERE oi.orderid = :orderid';
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':orderid', $orderId, -1, SQLT_INT);
    
        if (!oci_execute($stmt)) {
            oci_free_statement($stmt);
            oci_close($conn);
            throw new Exception("Fetching order items failed");
        }
    
        $items = [];
        while (($row = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) !== false) {
            $items[] = $row;
        }
    
        oci_free_statement($stmt);
        oci_close($conn);
        return $items;
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
    
        // Call the stored procedure to check overdue orders
        $procedureCall = 'BEGIN Update_Overdue_Warning(); END;';
        $procedureStmt = oci_parse($conn, $procedureCall);
        /*
        if (!oci_execute($procedureStmt)) {
            oci_free_statement($procedureStmt);
            oci_close($conn);
            
            throw new Exception("Failed to execute the procedure 'Check overdue orders'");
            
        }
        */
        
        oci_free_statement($procedureStmt);
    
        // Continue with fetching all orders
        $sql = 'SELECT * FROM orders ORDER BY orderid DESC';
        $stmt = oci_parse($conn, $sql);
        if (!oci_execute($stmt)) {
            oci_free_statement($stmt);
            oci_close($conn);
            throw new Exception("Failed to fetch all orders");
        }
    
        $orders = [];
        while ($row = oci_fetch_array($stmt, OCI_ASSOC)) {
            $orders[] = $row;
        }
    
        oci_free_statement($stmt);
        oci_close($conn);
        return $orders;
    }

    /**
     * Fetch all orders that are to be delivered
     * @return array - Array of orders
     * @throws Exception
     */
    public function fetchToBeDeliveredOrders(): array {
        $conn = getDatabaseConnection();
        $sql = 'SELECT ORDERID, USERID, ORDERDATE, TOTALAMOUNT, PAYED, "DeliveryDate"
                FROM orders 
                WHERE PaymentMethod = \'Pay on delivery\' AND "DeliveryDate" IS NULL
                ORDER BY ORDERDATE';
        $stmt = oci_parse($conn, $sql);
    
        if (!oci_execute($stmt)) {
            oci_free_statement($stmt);
            oci_close($conn);
            throw new Exception("Failed to fetch to be delivered orders");
        }
    
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
    public function fetchLastInsertedOrderByUser($userId)
    {
        $conn = getDatabaseConnection();
        $sql = 'SELECT *
                FROM orders
                WHERE userid = :userid
                ORDER BY orderid DESC
                FETCH FIRST 1 ROW ONLY';
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':userid', $userId, -1, SQLT_INT);

        oci_execute($stmt);

        $lastOrder = [];
        while ($row = oci_fetch_array($stmt, OCI_ASSOC)) {
            $lastOrder[] = $row;
        }
        $order = $lastOrder[0] ?? null;

        oci_free_statement($stmt);
        oci_close($conn);
        return $order;
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
            $payed = $paymentType === 'Credit Card' ? 'Y' : 'N';
            $sql = 'INSERT INTO orders (userid, totalamount, paymentmethod, zipcode, city, address, payed) VALUES(:userid, :total_amount, :payment_type, :zipcode, :city, :address, :payed)';
            $stmt = oci_parse($conn, $sql);
            oci_bind_by_name($stmt, ':userid', $userId);
            oci_bind_by_name($stmt, ':zipcode', $zipcode);
            oci_bind_by_name($stmt, ':city', $city);
            oci_bind_by_name($stmt, ':address', $address);
            oci_bind_by_name($stmt, ':payment_type', $paymentType);
            oci_bind_by_name($stmt, ':total_amount', $totalAmount);
            oci_bind_by_name($stmt, ':payed', $payed);

            if (!oci_execute($stmt)) {
                oci_rollback($conn);
                oci_free_statement($stmt);
                oci_close($conn);
                throw new Exception("Failed to create order!");
            }

            oci_free_statement($stmt);

            $lastInsertedOrder = $this->fetchLastInsertedOrderByUser($userId);

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
    public function insertIntoCartitems(array $cartItems, $conn, $lastInsertedOrder): bool
    {
        if ($lastInsertedOrder && $cartItems) {
            $orderId = $lastInsertedOrder["ORDERID"];
            try {
                foreach ($cartItems as $cartItem) {
                    $totalItemPrice = $cartItem['price'] * $cartItem['quantity'];
    
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
                    $this->deleteCartItems($cartItem['cartitemid']);
                }
            } catch (Exception $e) {
                oci_rollback($conn); // Rollback if any exception occurs
                throw new Exception($e->getMessage());
            }
            return true;
        }
        return false;
    }

    /**
     * Deletes all cart items for a specific cart by its ID
     * @param int $cartId - ID of the cart whose items need to be deleted
     * @return bool - Returns true if the operation is successful
     * @throws Exception - Throws an exception if the operation fails
     */
    private function deleteCartItems(int $cartitemid): bool {
        $conn = getDatabaseConnection();
        $sql = 'DELETE FROM cartitems WHERE cartitemid = :cartitemid';
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':cartitemid', $cartitemid);

        if (!oci_execute($stmt)) {
            $error = oci_error($stmt);
            oci_free_statement($stmt);
            oci_close($conn);
            throw new Exception("Failed to delete cart items: " . $error['message']);
        }

        oci_free_statement($stmt);
        oci_close($conn);
        return true;
    }

    /**
     * Update the paid status of an order
     * @param int $orderId
     * @param string $status
     * @return bool
     */
    public function updateOrderPaidStatus($orderId, $status) {
        $conn = getDatabaseConnection();
        $sql = 'UPDATE orders SET Payed = :status WHERE OrderID = :orderid';
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':status', $status);
        oci_bind_by_name($stmt, ':orderid', $orderId);
        $result = oci_execute($stmt);
        oci_free_statement($stmt);
        oci_close($conn);
        return $result;
    }
    
    /**
     * Update the delivered status of an order
     * @param int $orderId
     * @return bool
     */
    public function updateOrderDeliveredStatus($orderId) {
        $conn = getDatabaseConnection();
        $sql = 'UPDATE orders SET "DeliveryDate" = SYSDATE WHERE "ORDERID" = :orderid';
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':orderid', $orderId, -1); // Bind the Order ID, specify the length as -1 for integers

        $result = oci_execute($stmt);
        if (!$result) {
            $error = oci_error($stmt);
            oci_free_statement($stmt);
            oci_close($conn);
            throw new Exception("Failed to update delivered status: " . $error['message']);
        }
        oci_free_statement($stmt);
        oci_close($conn);
        return $result;  // Return true on success
    }


    // function to get blob from invoices table in the database where orderid is the given orderid

    /**
     * @throws Exception
     */
    public function getInvoiceBlob($orderId) {
        $conn = getDatabaseConnection();
        $sql = 'SELECT BLOB FROM INVOICES WHERE ORDERID = :orderid';
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':orderid', $orderId, -1, SQLT_INT);

        if (!oci_execute($stmt)) {
            oci_free_statement($stmt);
            oci_close($conn);
            throw new Exception("Failed to fetch invoice blob");
        }

        $row = oci_fetch_array($stmt, OCI_ASSOC);
        $invoiceBlob = $row['BLOB'] ?? null;

        oci_free_statement($stmt);
        oci_close($conn);
        return $invoiceBlob;
    }

    // function to insert blob into invoices table in the database

    /**
     * @throws Exception
     */
    public function insertInvoiceBlob($orderId, $blob) {
        $conn = getDatabaseConnection();
        $sql = 'INSERT INTO INVOICES (ORDERID, BLOB) VALUES (:orderid, :blob)';
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':orderid', $orderId, -1, SQLT_INT);
        oci_bind_by_name($stmt, ':bloburl', $blob, -1, SQLT_BLOB);

        if (!oci_execute($stmt)) {
            oci_free_statement($stmt);
            oci_close($conn);
            throw new Exception("Failed to insert invoice blob");
        }

        oci_commit($conn);
        oci_free_statement($stmt);
        oci_close($conn);
    }

    /**
     * @throws Exception
     */
    public function fetchOrderByOrderId($orderId) {
        $conn = getDatabaseConnection();
        $sql = 'SELECT * FROM orders WHERE orderid = :orderid';
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':orderid', $orderId, -1, SQLT_INT);

        if (!oci_execute($stmt)) {
            oci_free_statement($stmt);
            oci_close($conn);
            throw new Exception("Failed to fetch order by order ID");
        }

        $row = oci_fetch_array($stmt, OCI_ASSOC);
        $order = $row[0] ?? null;

        oci_free_statement($stmt);
        oci_close($conn);
        return $order;
    }




}