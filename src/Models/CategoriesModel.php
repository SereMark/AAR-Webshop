<?php
require_once __DIR__ . '/../Helpers/db.php';

class CategoriesModel {
    public function fetchCategories() {
        $conn = getDatabaseConnection();
        $stid = oci_parse($conn, 'SELECT * FROM categories');
        oci_execute($stid);
        $products = [];
        oci_fetch_all($stid, $products, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($stid);
        oci_close($conn);
        return $products;
    }
}