<?php
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
        // Get a connection to the database and prepare SQL statement
        $conn = getDatabaseConnection();
        $stid = oci_parse($conn, 'SELECT * FROM categories');

        // Execute the SQL statement and fetch all rows into the categories array
        oci_execute($stid);
        $categories = [];
        oci_fetch_all($stid, $categories, 0, -1, OCI_FETCHSTATEMENT_BY_ROW);

        // Clean up resources and return the categories
        oci_free_statement($stid);
        oci_close($conn);
        return $categories;
    }
}