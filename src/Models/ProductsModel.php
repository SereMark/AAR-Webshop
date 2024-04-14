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

        if (is_object($product['DESCRIPTION'])) {
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
        $sql = 'INSERT INTO products (name, price, description) VALUES (:name, :price, :description)';
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ':name', $productData['name']);
        oci_bind_by_name($stid, ':price', $productData['price']);
        oci_bind_by_name($stid, ':description', $productData['description']);

        $result = oci_execute($stid);
        oci_free_statement($stid);
        oci_close($conn);
        return $result;
    }
}