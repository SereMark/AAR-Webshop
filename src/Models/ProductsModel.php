<?php
require_once __DIR__ . '/../Helpers/db.php';

class ProductsModel {
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
}