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

    /**
     * Add a new category
     * @param string $categoryName
     * @return bool - Success status
     */
    public function addCategory($categoryName) {
        $conn = getDatabaseConnection();
        $sql = 'INSERT INTO categories (name) VALUES (:name)';
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':name', $categoryName);
    
        if (!oci_execute($stmt)) {
            $error = oci_error($stmt);
            oci_free_statement($stmt);
            oci_close($conn);
            throw new Exception("Failed to add category: " . $error['message']);
            return false;
        }
    
        oci_free_statement($stmt);
        oci_close($conn);
        return true;
    }

    /**
     * Delete a category by its ID
     * @param int $categoryId
     * @return bool - Success status
     */
    public function deleteCategoryById($categoryId) {
        $conn = getDatabaseConnection();
        $sql = 'DELETE FROM categories WHERE categoryid = :categoryid';
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':categoryid', $categoryId);
        
        if (!oci_execute($stmt)) {
            $error = oci_error($stmt);
            oci_free_statement($stmt);
            oci_close($conn);
            throw new Exception("Failed to delete category: " . $error['message']);
            return false;
        }
        
        oci_free_statement($stmt);
        oci_close($conn);
        return true;
    }    
}