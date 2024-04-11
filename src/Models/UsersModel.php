<?php
require_once __DIR__ . '/../Helpers/db.php';

class UsersModel {
    public function createUser(string $name, string $email, string $phonenumber, string $passwordHash): bool {
        $conn = getDatabaseConnection();
        $sql = 'INSERT INTO USERS (NAME, EMAIL, PHONENUMBER, ISADMIN, PASSWORDHASH) VALUES (:NAME, :EMAIL, :PHONENUMBER, :ISADMIN, :PASSWORDHASH)';
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ':NAME', $name);
        oci_bind_by_name($stmt, ':EMAIL', $email);
        $isadmin = 'N'; // Default to non-admin
        oci_bind_by_name($stmt, ':ISADMIN', $isadmin);    
        oci_bind_by_name($stmt, ':PHONENUMBER', $phonenumber);
        oci_bind_by_name($stmt, ':PASSWORDHASH', $passwordHash);

        if (!oci_execute($stmt)) {
            oci_free_statement($stmt);
            oci_close($conn);
            return false;
        }

        oci_free_statement($stmt);
        oci_close($conn);

        return true;
    }
    
    public function doesUserExistByEmail($email) {
        $conn = getDatabaseConnection();
        $sql = 'SELECT COUNT(*) AS num FROM USERS WHERE EMAIL = :EMAIL';
        $stid = oci_parse($conn, $sql);
        
        oci_bind_by_name($stid, ':EMAIL', $email);
        
        if (!oci_execute($stid)) {
            return false;
        }
        
        $row = oci_fetch_array($stid, OCI_ASSOC);
            
        oci_free_statement($stid);
        oci_close($conn);
        
        return $row && $row['NUM'] > 0;
    }

    public function getUserDetailsByEmail($email) {
        $conn = getDatabaseConnection();
        $sql = 'SELECT * FROM USERS WHERE EMAIL = :EMAIL';
        $stid = oci_parse($conn, $sql);
        
        oci_bind_by_name($stid, ':EMAIL', $email);
        
        if (!oci_execute($stid)) {
            return false;
        }
        
        $row = oci_fetch_array($stid, OCI_ASSOC);
        
        oci_free_statement($stid);
        oci_close($conn);
        
        return $row ?: false;
    }    
}