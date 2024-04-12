<?php
// Include the database helper file
require_once __DIR__ . '/../Helpers/db.php';

// Define the ProductsModel class
class ProductsModel {
    // Define a method to fetch all products from the database
    public function fetchProducts() {
        // Get a connection to the database
        $conn = getDatabaseConnection();
        // Prepare a SQL statement to select all records from the products table
        $stid = oci_parse($conn, 'SELECT * FROM products');
        // Execute the SQL statement
        oci_execute($stid);
        // Initialize an empty array to hold the products
        $products = [];
        // Fetch all rows from the result of the SQL statement into the products array
        oci_fetch_all($stid, $products, 0, -1, OCI_FETCHSTATEMENT_BY_ROW);
        // Free the resources associated with the SQL statement
        oci_free_statement($stid);
        // Close the connection to the database
        oci_close($conn);
        // Return the products
        return $products;
    }
}