<?php
require_once __DIR__ . '/../Helpers/db.php';

/**
 * Class CategoriesModel
 * Handles category-related database operations
 */
class CategoriesModel {
    /**
     * Fetch all categories from the database
     * @return array - Array of categories
     */
    public function fetchCategories() {
        $conn = getDatabaseConnection();
        $stid = oci_parse($conn, 'SELECT * FROM categories');

        oci_execute($stid);
        $categories = [];
        oci_fetch_all($stid, $categories, 0, -1, OCI_FETCHSTATEMENT_BY_ROW);

        oci_free_statement($stid);
        oci_close($conn);
        return $categories;
    }
}