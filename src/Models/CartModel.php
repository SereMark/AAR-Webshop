<?php
/**
 * Class CartModel
 * Handles cart-related database operations
 */
class CartModel {
    private $db;

    /**
     * CartModel constructor
     * Initializes database connection
     */
    public function __construct() {
        $this->db = getDatabaseConnection();
    }

    /**
     * Get cart items by user ID
     * @param int $userId - ID of the user
     * @return array - Array of cart items
     */
    public function getCartItemsByUserId($userId) {
        $sql = "SELECT ci.cartitemid, ci.productid, p.name, p.price 
                FROM cartitems ci 
                JOIN products p ON ci.productid = p.productid 
                WHERE ci.cartid = (SELECT cart.cartid FROM cart WHERE cart.userid = :userid)";
 
        $stmt = oci_parse($this->db, $sql);
        oci_bind_by_name($stmt, ':userid', $userId);
        oci_execute($stmt);
 
        $cartItems = [];
        while ($row = oci_fetch_assoc($stmt)) {
            $cartItems[] = [
                'cartitemid' => $row['CARTITEMID'],
                'productid' => $row['PRODUCTID'],
                'productname' => $row['NAME'], 
                'price' => $row['PRICE']
            ];
        }
 
        return $cartItems;
    }

    /**
     * Add an item to the cart
     * @param int $userId - ID of the user
     * @param int $productId - ID of the product
     * @return bool - True if the item was added successfully, false otherwise
     */
    public function addItemToCart($userId, $productId) {
        // First, get the cart ID for the user
        $sql = "SELECT cartid FROM cart WHERE userid = :userid";
        $stmt = oci_parse($this->db, $sql);
        oci_bind_by_name($stmt, ':userid', $userId);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);
        $cartId = $row['CARTID'] ?? null;

        // If the user doesn't have a cart, create one
        if (!$cartId) {
            $sql = "BEGIN INSERT INTO cart (userid) VALUES (:userid) RETURNING cartid INTO :cartid; END;";
            $stmt = oci_parse($this->db, $sql);
            oci_bind_by_name($stmt, ':userid', $userId);
            oci_bind_by_name($stmt, ':cartid', $cartId, SQLT_INT);
            oci_execute($stmt);
        }

        // Add the product to the cart
        $sql = "INSERT INTO cartitems (cartid, productid) VALUES (:cartid, :productid)";
        $stmt = oci_parse($this->db, $sql);
        oci_bind_by_name($stmt, ':cartid', $cartId);
        oci_bind_by_name($stmt, ':productid', $productId);

        return oci_execute($stmt);
    }
}