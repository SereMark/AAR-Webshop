<?php
require_once __DIR__ . '/../Helpers/db.php';

/**
 * Class CheckoutModel
 * Handles checkout-related database operations
 */
class CheckoutModel {
    /**
     * Create a new order in the database
     * @param int $userId User ID for the order
     * @param float $totalPrice Total price of the order
     * @return false|int Order ID on success, false on failure
     * @throws Exception
     */
    public function createOrder(int $userId, float $totalPrice) {
        $conn = getDatabaseConnection();
        $sql = 'INSERT INTO orders (userid, totalamount) VALUES (:userid, :totalprice) RETURNING orderid INTO :orderid';
        $stmt = oci_parse($conn, $sql);

        // Initializing the variables to hold the output
        $orderId = 0;

        oci_bind_by_name($stmt, ':userid', $userId, -1, SQLT_INT);
        oci_bind_by_name($stmt, ':totalprice', $totalPrice);
        oci_bind_by_name($stmt, ':orderid', $orderId, -1, SQLT_INT);

        if (!oci_execute($stmt)) {
            oci_free_statement($stmt);
            oci_close($conn);
            return false;
        }

        // Commit the changes
        oci_commit($conn);

        oci_free_statement($stmt);
        oci_close($conn);
        return $orderId;
    }

    /**
     * Add items to the order
     * @param int $orderId Order ID to which items should be added
     * @param array $items Items to add
     * @return bool True on success, false on failure
     * @throws Exception
     */
    /*
    public function addOrderItems($orderId, $items) {
        $conn = getDatabaseConnection();
        $sql = 'INSERT INTO orderitems (orderid, productid, quantity, price) VALUES (:orderid, :productid, :quantity, :price)';
        $stmt = oci_parse($conn, $sql);

        foreach ($items as $item) {
            oci_bind_by_name($stmt, ':orderid', $orderId, -1, SQLT_INT);
            oci_bind_by_name($stmt, ':productid', $item['productid'], -1, SQLT_INT);
            oci_bind_by_name($stmt, ':quantity', $item['quantity'], -1, SQLT_INT);
            oci_bind_by_name($stmt, ':price', $item['price']);

            if (!oci_execute($stmt)) {
                oci_free_statement($stmt);
                oci_close($conn);
                return false;
            }
        }

        // Commit the changes
        oci_commit($conn);

        oci_free_statement($stmt);
        oci_close($conn);
        return true;
    }*/

}