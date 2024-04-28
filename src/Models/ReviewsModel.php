<?php
require_once __DIR__ . '/../Helpers/db.php';

/**
 * Class ReviewsModel
 * Handles review-related database operations
 */
class ReviewsModel {
    /**
     * Fetch all reviews for a specific product by its ID and sort by rating
     * @param int $productId
     * @param string $order ('asc' for ascending, 'desc' for descending)
     * @return array - Array of reviews
     */
    public function getReviewsByProductId($productId, $order = 'desc') {
        $conn = getDatabaseConnection();
        $sql = 'SELECT * FROM reviews WHERE productid = :id ORDER BY rating ' . ($order === 'asc' ? 'ASC' : 'DESC') . ', reviewid DESC';
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ':id', $productId, -1, SQLT_INT);
        oci_execute($stid);

        $reviews = [];
        while (($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_LOBS)) !== false) {
            $reviews[] = $row;
        }

        oci_free_statement($stid);
        oci_close($conn);
        return $reviews;
    }

    /**
     * Fetch a review by its ID
     * @param int $reviewId
     * @return mixed - Review data or false if not found
     */
    public function getReviewById($reviewId) {
        $conn = getDatabaseConnection();
        $sql = 'SELECT * FROM reviews WHERE reviewid = :reviewid';
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ':reviewid', $reviewId, -1, SQLT_INT);

        if (!oci_execute($stmt)) {
            oci_free_statement($stmt);
            oci_close($conn);
            return false;
        }

        $review = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS);
        oci_free_statement($stmt);
        oci_close($conn);
        return $review;
    }

    /**
     * Add a new review
     * @return bool - Success status
     */
    public function addReview($userId, $productId, $rating, $text) {
        $conn = getDatabaseConnection();
        $sql = 'INSERT INTO reviews (userid, productid, rating, text) VALUES (:userid, :productid, :rating, :text)';
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ':userid', $userId);
        oci_bind_by_name($stmt, ':productid', $productId);
        oci_bind_by_name($stmt, ':rating', $rating);
        oci_bind_by_name($stmt, ':text', $text);

        if (!oci_execute($stmt)) {
            $e = oci_error($stmt);
            oci_free_statement($stmt);
            oci_close($conn);
            return false;
        }

        oci_free_statement($stmt);
        oci_close($conn);
        return true;
    }

    /**
     * Deletes a review by its ID
     * @param int $reviewId - ID of the review
     * @return bool - True if the review was deleted successfully, false otherwise
     */
    public function deleteReview($reviewId) {
        $conn = getDatabaseConnection();
        $sql = 'DELETE FROM reviews WHERE reviewid = :reviewid';
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ':reviewid', $reviewId, -1, SQLT_INT);

        if (!oci_execute($stmt)) {
            oci_free_statement($stmt);
            oci_close($conn);
            return false;
        }

        oci_free_statement($stmt);
        oci_close($conn);
        return true;
    }

    /**
     * Fetch all reviews for a specific user by their ID
     * @param int $userId
     * @return array - Array of reviews
     */
    public function getReviewsByUserId($userId) {
        $conn = getDatabaseConnection();
        $sql = 'SELECT r.reviewid, r.rating, r.text, p.name AS product_name 
                FROM reviews r
                INNER JOIN products p ON r.productid = p.productid
                WHERE r.userid = :userid 
                ORDER BY r.reviewid DESC';
        $stmt = oci_parse($conn, $sql);
    
        oci_bind_by_name($stmt, ':userid', $userId, -1, SQLT_INT);
    
        if (!oci_execute($stmt)) {
            oci_free_statement($stmt);
            oci_close($conn);
            return false;
        }
    
        $reviews = [];
        while (($row = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) !== false) {
            if($row['TEXT'] instanceof OCILob) {
                $row['TEXT'] = $row['TEXT']->load();
            }
            $reviews[] = $row;
        }
    
        oci_free_statement($stmt);
        oci_close($conn);
        return $reviews;
    }    

    /**
     * Deletes all reviews for a specific user by their ID
     * @param int $userId
     * @return bool - True if the reviews were deleted successfully, false otherwise
     */
    public function deleteAllReviewsByUserId($userId) {
        $conn = getDatabaseConnection();
        $sql = 'DELETE FROM reviews WHERE userid = :userid';
        $stmt = oci_parse($conn, $sql);
    
        oci_bind_by_name($stmt, ':userid', $userId, -1, SQLT_INT);
    
        if (!oci_execute($stmt)) {
            oci_free_statement($stmt);
            oci_close($conn);
            return false;
        }
    
        oci_free_statement($stmt);
        oci_close($conn);
        return true;
    }

    /**
     * Fetch the count of reviews for a specific user by their ID
     * @param int $userId
     * @return int - Count of reviews
     */
    public function getReviewCountByUserId($userId) {
        $conn = getDatabaseConnection();
        $sql = 'SELECT COUNT(*) AS review_count FROM reviews WHERE userid = :userid';
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ':userid', $userId, -1, SQLT_INT);

        if (!oci_execute($stmt)) {
            oci_free_statement($stmt);
            oci_close($conn);
            return 0;
        }

        $row = oci_fetch_array($stmt, OCI_ASSOC);
        $count = $row['REVIEW_COUNT'] ?? 0;

        oci_free_statement($stmt);
        oci_close($conn);
        return $count;
    }

    /**
     * Fetch all reviews from the database
     * @return array - Array of reviews
     */
    public function fetchAllReviews() {
        $conn = getDatabaseConnection();
        $sql = 'SELECT r.reviewid, r.rating, r.text, p.name AS product_name, r.productid, r.userid 
                FROM reviews r
                INNER JOIN products p ON r.productid = p.productid
                ORDER BY r.reviewid DESC';
        $stmt = oci_parse($conn, $sql);
        oci_execute($stmt);
        
        $reviews = [];
        while ($row = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_LOBS)) {
            // Checking if the TEXT column is a LOB and loading it appropriately
            if ($row['TEXT'] instanceof OCILob) {
                $row['TEXT'] = $row['TEXT']->load();
            }
            $reviews[] = $row;
        }
        
        oci_free_statement($stmt);
        oci_close($conn);
        return $reviews;
    }    
}