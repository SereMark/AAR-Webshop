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
        // Obtain a database connection
        $conn = getDatabaseConnection();
    
        // Define the SQL query with placeholders for the parameters
        // Using placeholders helps to prevent SQL injection by separating data from SQL commands
        $sql = 'INSERT INTO USERS (NAME, EMAIL, PHONENUMBER, ISADMIN, PASSWORDHASH) VALUES (:NAME, :EMAIL, :PHONENUMBER, :ISADMIN, :PASSWORDHASH)';
        
        // Prepare the SQL statement
        // The oci_parse function prepares the SQL query for execution
        $stmt = oci_parse($conn, $sql);
    
        // Bind the actual values to the placeholders in the SQL statement
        // oci_bind_by_name binds the user input values to the named placeholders, ensuring that they are treated as data
        oci_bind_by_name($stmt, ':NAME', $name);
        oci_bind_by_name($stmt, ':EMAIL', $email);
        $isadmin = 'N'; // Default to non-admin
        oci_bind_by_name($stmt, ':ISADMIN', $isadmin);    
        oci_bind_by_name($stmt, ':PHONENUMBER', $phonenumber);
        oci_bind_by_name($stmt, ':PASSWORDHASH', $passwordHash);
    
        // Execute the SQL statement
        // The oci_execute function executes the prepared statement with the bound values
        // Since the query is already prepared with placeholders, user input is safely processed as data
        if (!oci_execute($stmt)) {
            // If execution fails, free the statement and close the connection
            // This ensures proper resource management and error handling
            oci_free_statement($stmt);
            oci_close($conn);
            return false;
        }
    
        // If execution succeeds, free the statement and close the connection
        // This ensures that there are no resource leaks
        oci_free_statement($stmt);
        oci_close($conn);
        return true;
    }    


    /**
     * Get the total revenue for each month of the current year
     * @return array|false
     * @throws Exception
     */
    public function fetchStatistics(): string {
        $conn = getDatabaseConnection();
        $stmt = oci_parse($conn, 'BEGIN Fetch_Yearly_Revenue(:cursor); END;');
        $cursor = oci_new_cursor($conn);
    
        // Bind the cursor as an output parameter
        oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);
    
        // Execute the statement
        if (!oci_execute($stmt)) {
            oci_free_statement($stmt);
            oci_close($conn);
            return false; // It's better to throw an exception or handle errors appropriately
        }
    
        // Execute the cursor like a normal statement
        oci_execute($cursor);
    
        $results = [];
        while ($row = oci_fetch_assoc($cursor)) {
            $results[] = $row;
        }
    
        oci_free_statement($cursor);
        oci_free_statement($stmt);
        oci_close($conn);
    
        // Encode data as JSON
        return json_encode($results);
    }    


    /**
     * Check if a user exists by email
     * @return bool - Existence of user
     * @throws Exception
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

    public function updateBalanceById($userId, $balance) {
        $conn = getDatabaseConnection();
        $sql = 'UPDATE USERS SET BALANCE = BALANCE - :balance WHERE USERID = :USERID';
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ':balance', $balance);
        oci_bind_by_name($stmt, ':USERID', $userId);

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

    

    public function updateBalance($userId, $balance, $card_number, $cvc, $expiry_date) {
        $conn = getDatabaseConnection();
        $sql = 'UPDATE USERS SET BALANCE = BALANCE + :balance, CARD_NUMBER = :card_number, cvc = :cvc, EXPIRY_DATE = :expiry_date WHERE USERID = :USERID';
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ':balance', $balance);
        oci_bind_by_name($stmt, ':USERID', $userId);
        oci_bind_by_name($stmt, ':card_number', $card_number);
        oci_bind_by_name($stmt, ':cvc', $cvc);
        oci_bind_by_name($stmt, ':expiry_date', $expiry_date);

        $result = oci_execute($stmt);
        oci_free_statement($stmt);
        oci_close($conn);
        return $result;
    }

    public function fetchAllUsers() {
        $conn = getDatabaseConnection();
        $sql = "SELECT USERID, NAME, EMAIL, ISADMIN FROM USERS";
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

    public function setAdminStatus($userId, $newStatus) {
        $conn = getDatabaseConnection();
        $sql = 'UPDATE USERS SET ISADMIN = :ISADMIN WHERE USERID = :USERID';
        $stmt = oci_parse($conn, $sql);
    
        oci_bind_by_name($stmt, ':ISADMIN', $newStatus);
        oci_bind_by_name($stmt, ':USERID', $userId);
    
        $result = oci_execute($stmt);
        oci_free_statement($stmt);
        oci_close($conn);
        return $result;
    }    

    
    public function getBalanceByUserId($userId) {
        $conn = getDatabaseConnection();
        $sql = 'SELECT BALANCE FROM users WHERE userid = :userid';
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ':userid', $userId, -1, SQLT_INT);

        if (!oci_execute($stmt)) {
            oci_free_statement($stmt);
            oci_close($conn);
            return 0;
        }

        $row = oci_fetch_array($stmt, OCI_ASSOC);
        $count = $row['BALANCE'] ?? 0;

        oci_free_statement($stmt);
        oci_close($conn);
        return $count;
    }
    


}