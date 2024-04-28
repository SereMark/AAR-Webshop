<?php
require_once __DIR__ . '/../Helpers/db.php';

/**
 * Class CouponsModel
 * Handles coupon-related database operations
 */
class CouponsModel
{
    /**
     * Fetches all coupons from the database
     * @return array
     * @throws Exception
     */
    public function fetchCoupons(){
        $conn = getDatabaseConnection();
        $sql = 'SELECT * FROM coupons';
        $stmt = oci_parse($conn, $sql);

        if (!oci_execute($stmt)) {
            oci_free_statement($stmt);
            oci_close($conn);
            throw new Exception("Fetching coupons execution error");
        }

        $coupons = [];
        while (($row = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) !== false) {
            $coupons[] = $row;
        }

        oci_free_statement($stmt);
        oci_close($conn);
        return $coupons;
    }

    /**
     * Check if a coupon code already exists in the database
     * @param $couponCode
     * @return bool
     * @throws Exception
     */
    public function couponExists($couponCode) {
        $conn = getDatabaseConnection();
        $sql = 'SELECT COUNT(*) AS num FROM coupons WHERE CODE = :CODE';
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':CODE', $couponCode);
        if (!oci_execute($stmt)) {
            oci_free_statement($stmt);
            oci_close($conn);
            throw new Exception("Check coupon existence execution error");
        }

        $result = oci_fetch_array($stmt, OCI_ASSOC);
        return isset($result['NUM']) && $result['NUM'] > 0;        
    }

    /**
     * Adds a coupon to the database
     * @param $couponCode
     * @param $couponDiscount
     * @throws Exception
     */
    public function addCoupon($couponCode, $couponDiscount) {
        $conn = getDatabaseConnection();
        $sql = 'INSERT INTO coupons (CODE, DISCOUNT) VALUES (:CODE, :DISCOUNT)';
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':CODE', $couponCode);
        oci_bind_by_name($stmt, ':DISCOUNT', $couponDiscount);

        if (!oci_execute($stmt)) {
            oci_free_statement($stmt);
            oci_close($conn);
            throw new Exception("Adding coupon execution error");
        }

        oci_free_statement($stmt);
        oci_close($conn);
    }

    /**
     * Deletes a coupon from the database
     * @param $couponId
     * @throws Exception
     */
    public function deleteCoupon($couponId){
        $conn = getDatabaseConnection();
        $sql = 'DELETE FROM coupons WHERE COUPONID = :coupon_id';
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':coupon_id', $couponId);

        if (!oci_execute($stmt)) {
            oci_free_statement($stmt);
            oci_close($conn);
            throw new Exception("Deleting coupon execution error");
        }

        oci_free_statement($stmt);
        oci_close($conn);
    }
}