<?php
require_once __DIR__ . '/../Helpers/db.php';

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
        $sql = "SELECT ci.cartitemid, ci.productid, p.name, p.price, ci.quantity 
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
                'price' => $row['PRICE'],
                'quantity' => $row['QUANTITY']
            ];
        }
    
        return $cartItems;
    }    

    /**
     * Get or create a cart ID for a given user
     * @param int $userId - ID of the user
     * @return int - Cart ID
     */
    private function getOrCreateCartId($userId) {
        // First, try to fetch the existing cart ID
        $sql = "SELECT cartid FROM cart WHERE userid = :userid";
        $stmt = oci_parse($this->db, $sql);
        oci_bind_by_name($stmt, ':userid', $userId);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);

        if ($row) {
            return $row['CARTID']; // Return existing cart ID
        } else {
            // If no cart exists, create a new one
            $sql = "INSERT INTO cart (userid) VALUES (:userid) RETURNING cartid INTO :cartid";
            $stmt = oci_parse($this->db, $sql);
            oci_bind_by_name($stmt, ':userid', $userId);

            // Using a variable to store the returned cart ID
            $cartId = null;
            oci_bind_by_name($stmt, ':cartid', $cartId, -1, OCI_B_INT);
            oci_execute($stmt);

            return $cartId; // Return new cart ID
        }
    }

    /**
     * Updates the quantity of a cart item
     * @param int $cartItemId - ID of the cart item
     * @param int $quantity - New quantity
     * @return bool - True if the update was successful, false otherwise
     */
    public function updateCartItemQuantity($cartItemId, $quantity) {
        $sql = "UPDATE cartitems SET quantity = :quantity WHERE cartitemid = :cartitemid";
        $stmt = oci_parse($this->db, $sql);
        oci_bind_by_name($stmt, ':quantity', $quantity);
        oci_bind_by_name($stmt, ':cartitemid', $cartItemId);
        return oci_execute($stmt);
    }

    /**
     * Add an item to the cart
     * @param int $userId - ID of the user
     * @param int $productId - ID of the product
     * @return bool - True if the item was added successfully, false otherwise
     */
    public function addItemToCart($userId, $productId, $quantity = 1) {
        // Check if product already in cart and update quantity
        $sql = "SELECT cartitemid, quantity FROM cartitems WHERE cartid = (SELECT cartid FROM cart WHERE userid = :userid) AND productid = :productid";
        $stmt = oci_parse($this->db, $sql);
        oci_bind_by_name($stmt, ':userid', $userId);
        oci_bind_by_name($stmt, ':productid', $productId);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);
    
        if ($row) {
            $newQuantity = $row['QUANTITY'] + $quantity;
            $sql = "UPDATE cartitems SET quantity = :quantity WHERE cartitemid = :cartitemid";
            $stmt = oci_parse($this->db, $sql);
            oci_bind_by_name($stmt, ':quantity', $newQuantity);
            oci_bind_by_name($stmt, ':cartitemid', $row['CARTITEMID']);
            return oci_execute($stmt);
        } else {
            // If product is not in the cart, insert new
            $cartId = $this->getOrCreateCartId($userId);
            $sql = "INSERT INTO cartitems (cartid, productid, quantity) VALUES (:cartid, :productid, :quantity)";
            $stmt = oci_parse($this->db, $sql);
            oci_bind_by_name($stmt, ':cartid', $cartId);
            oci_bind_by_name($stmt, ':productid', $productId);
            oci_bind_by_name($stmt, ':quantity', $quantity);
            return oci_execute($stmt);
        }
    }    

    /**
     * Removes an item from the cart
     * @param int $cartItemId - ID of the cart item
     * @return bool - True if the item was removed successfully, false otherwise
     */
    public function removeItemFromCart($cartItemId) {
        $sql = "DELETE FROM cartitems WHERE cartitemid = :cartitemid";
        $stmt = oci_parse($this->db, $sql);
        oci_bind_by_name($stmt, ':cartitemid', $cartItemId);

        return oci_execute($stmt);
    }
}