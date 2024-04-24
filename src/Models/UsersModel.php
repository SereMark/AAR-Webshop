<?php
require_once __DIR__ . '/../Helpers/db.php';

/**
 * Class UsersModel
 * Handles user-related database operations
 */
class UsersModel {
    /**
     * Create a new user
     * @return bool - Success status
     */
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
    
    /**
     * Check if a user exists by email
     * @return bool - Existence of user
     */
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

    /**
     * Get a user's details by email
     * @return array|bool - User details or false if not found
     */
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

    /**
     * Delete a user by email
     * @return bool - Success status
     */
    public function deleteUserByEmail($email) {
        $conn = getDatabaseConnection();
        $sql = 'DELETE FROM USERS WHERE EMAIL = :EMAIL';
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ':EMAIL', $email);
        
        if (!oci_execute($stid)) {
            $error = oci_error($stid);
            oci_free_statement($stid);
            oci_close($conn);
            throw new Exception("Database error: " . $error['message']);
            return false;
        }
        
        oci_free_statement($stid);
        oci_close($conn);
        return true;
    }

    /**
     * Delete a user by ID
     * @return bool - Success status
     */
    public function deleteUserById($userId) {
        $conn = getDatabaseConnection();
        $sql = 'DELETE FROM USERS WHERE USERID = :USERID';
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ':USERID', $userId);
        
        if (!oci_execute($stid)) {
            $error = oci_error($stid);
            oci_free_statement($stid);
            oci_close($conn);
            throw new Exception("Database error: " . $error['message']);
            return false;
        }
        
        oci_free_statement($stid);
        oci_close($conn);
        return true;
    }

    /**
     * Get a user's details by ID
     * @return array|bool - User details or false if not found
     */
    public function getUserDetailsById($userId) {
        $conn = getDatabaseConnection();
        $sql = 'SELECT * FROM USERS WHERE USERID = :USERID';
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ':USERID', $userId);
        
        if (!oci_execute($stid)) {
            return false;
        }
        
        $row = oci_fetch_array($stid, OCI_ASSOC);
        oci_free_statement($stid);
        oci_close($conn);
        
        return $row ?: false;
    }

    public function updateUser($userId, $name, $email, $phoneNumber) {
        $conn = getDatabaseConnection();
        $sql = 'UPDATE USERS SET NAME = :NAME, EMAIL = :EMAIL, PHONENUMBER = :PHONENUMBER WHERE USERID = :USERID';
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ':USERID', $userId);
        oci_bind_by_name($stmt, ':NAME', $name);
        oci_bind_by_name($stmt, ':EMAIL', $email);
        oci_bind_by_name($stmt, ':PHONENUMBER', $phoneNumber);

        $result = oci_execute($stmt);
        oci_free_statement($stmt);
        oci_close($conn);
        return $result;
    }

    public function updatePassword($userId, $passwordHash) {
        $conn = getDatabaseConnection();
        $sql = 'UPDATE USERS SET PASSWORDHASH = :PASSWORDHASH WHERE USERID = :USERID';
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ':PASSWORDHASH', $passwordHash);
        oci_bind_by_name($stmt, ':USERID', $userId);

        $result = oci_execute($stmt);
        oci_free_statement($stmt);
        oci_close($conn);
        return $result;
    }

    public function fetchAllUsers() {
        $conn = getDatabaseConnection();
        $sql = "SELECT USERID, NAME, EMAIL FROM USERS";
        $stmt = oci_parse($conn, $sql);
        oci_execute($stmt);
        $users = [];
        while ($row = oci_fetch_assoc($stmt)) {
            $users[] = $row;
        }
        oci_free_statement($stmt);
        oci_close($conn);
        return $users;
    }
}