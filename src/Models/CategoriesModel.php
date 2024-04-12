<?php
// Include the database helper file
require_once __DIR__ . '/../Helpers/db.php';

// Define the CategoriesModel class
class CategoriesModel {
    // Define a method to fetch all categories from the database
    public function fetchCategories() {
        // Get a connection to the database
        $conn = getDatabaseConnection();
        // Prepare a SQL statement to select all records from the categories table
        $stid = oci_parse($conn, 'SELECT * FROM categories');
        // Execute the SQL statement
        oci_execute($stid);
        // Initialize an empty array to hold the categories
        $categories = [];
        // Fetch all rows from the result of the SQL statement into the categories array
        oci_fetch_all($stid, $categories, 0, -1, OCI_FETCHSTATEMENT_BY_ROW);
        // Free the resources associated with the SQL statement
        oci_free_statement($stid);
        // Close the connection to the database
        oci_close($conn);
        // Return the categories
        return $categories;
    }
}