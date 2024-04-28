<?php
require_once __DIR__ . '/../Helpers/db.php';

/**
 * Class ProductsModel
 * Handles product-related database operations
 */
class ProductsModel {
    /**
     * Fetch all products from the database
     * @return array - Array of products
     */
    public function fetchProducts() {
        $conn = getDatabaseConnection();
        $stid = oci_parse($conn, 'SELECT * FROM products');
        oci_execute($stid);
        $products = [];
        oci_fetch_all($stid, $products, 0, -1, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($stid);
        oci_close($conn);
        return $products;
    }

    /**
     * Fetch a single product by its ID
     * @return array - Product details
     */
    public function fetchProductById($productId) {
        $conn = getDatabaseConnection();
        $sql = 'SELECT * FROM products WHERE productid = :id';
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ':id', $productId, -1, SQLT_INT);
        oci_execute($stid);
        $product = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_LOBS);

        if (isset($product['DESCRIPTION']) && is_object($product['DESCRIPTION'])) {
            $product['DESCRIPTION'] = $product['DESCRIPTION']->load();
        }

        oci_free_statement($stid);
        oci_close($conn);
        return $product;
    }

    /**
     * Add a new product to the database
     * @param array $productData - Data of the product to add
     * @return bool - True if successful, false otherwise
     */
    public function addProduct($productData) {
        $conn = getDatabaseConnection();
        $sql = 'INSERT INTO products (name, price, description, categoryID, userid) VALUES (:name, :price, :description, :categoryID, :userid)';
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ':name', $productData['name']);
        oci_bind_by_name($stid, ':price', $productData['price']);
        oci_bind_by_name($stid, ':description', $productData['description']);
        oci_bind_by_name($stid, ':categoryID', $productData['categoryID']);
        oci_bind_by_name($stid, ':userid', $productData['userid']);

        $result = oci_execute($stid);
        oci_free_statement($stid);
        oci_close($conn);
        return $result;
    }

    /**
     * Fetch all products for a specific user by their ID
     * @param int $userId
     * @return array - Array of products
     */
    public function fetchProductsByUserId($userId) {
        $conn = getDatabaseConnection();
        $sql = 'SELECT * FROM products WHERE userid = :userid';
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ':userid', $userId, -1, SQLT_INT);
        oci_execute($stid);

        $products = [];
        oci_fetch_all($stid, $products, 0, -1, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($stid);
        oci_close($conn);
        return $products;
    }

    /**
     * Fetch the count of products for a specific user by their ID
     * @param int $userId
     * @return int - Count of products
     */
    public function getProductCountByUserId($userId) {
        $conn = getDatabaseConnection();
        $sql = 'SELECT COUNT(*) AS product_count FROM products WHERE userid = :userid';
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ':userid', $userId, -1, SQLT_INT);

        if (!oci_execute($stmt)) {
            oci_free_statement($stmt);
            oci_close($conn);
            return 0;
        }

        $row = oci_fetch_array($stmt, OCI_ASSOC);
        $count = $row['PRODUCT_COUNT'] ?? 0;

        oci_free_statement($stmt);
        oci_close($conn);
        return $count;
    }

    /**
     * Search products in the database
     * @param string $term The search term
     * @return array - Array of found products
     */
    public function searchProducts($term) {
        $conn = getDatabaseConnection();
        $sql = "SELECT * FROM products WHERE LOWER(name) LIKE LOWER(:term) OR LOWER(description) LIKE LOWER(:term)";
        $stid = oci_parse($conn, $sql);
        $likeTerm = '%' . $term . '%';
        oci_bind_by_name($stid, ':term', $likeTerm);
        
        oci_execute($stid);
        $products = [];
        oci_fetch_all($stid, $products, 0, -1, OCI_FETCHSTATEMENT_BY_ROW);
        
        oci_free_statement($stid);
        oci_close($conn);
        return $products;
    }    

    /**
     * Delete a product by its ID
     * @param int $productId
     * @return bool - True if the product was deleted successfully, false otherwise
     */
    public function deleteProduct($productId) {
        $conn = getDatabaseConnection();
        $sql = 'DELETE FROM products WHERE productid = :productid';
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':productid', $productId);
    
        if (!oci_execute($stmt)) {
            $error = oci_error($stmt);
            oci_free_statement($stmt);
            oci_close($conn);
            throw new Exception("Failed to delete product: " . $error['message']);
            return false;
        }
    
        oci_free_statement($stmt);
        oci_close($conn);
        return true;
    }

    /**
     * Delete all products for a specific user by their ID
     * @param int $userId
     * @return bool - True if the products were deleted successfully, false otherwise
     */
    public function deleteAllProductsByUserId($userId) {
        $conn = getDatabaseConnection();
        $sql = 'DELETE FROM products WHERE userid = :userid';
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':userid', $userId);
    
        if (!oci_execute($stmt)) {
            $error = oci_error($stmt);
            oci_free_statement($stmt);
            oci_close($conn);
            throw new Exception("Failed to delete products: " . $error['message']);
            return false;
        }
    
        oci_free_statement($stmt);
        oci_close($conn);
        return true;
    }
}