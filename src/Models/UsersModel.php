<?php
// Include the database helper file
require_once __DIR__ . '/../Helpers/db.php';

// Define the UsersModel class
class UsersModel {
    // Define a method to create a new user
    public function createUser(string $name, string $email, string $phonenumber, string $passwordHash): bool {
        // Get a connection to the database
        $conn = getDatabaseConnection();
        // Prepare a SQL statement to insert a new record into the users table
        $sql = 'INSERT INTO USERS (NAME, EMAIL, PHONENUMBER, ISADMIN, PASSWORDHASH) VALUES (:NAME, :EMAIL, :PHONENUMBER, :ISADMIN, :PASSWORDHASH)';
        $stmt = oci_parse($conn, $sql);

        // Bind the parameters to the SQL statement
        oci_bind_by_name($stmt, ':NAME', $name);
        oci_bind_by_name($stmt, ':EMAIL', $email);
        $isadmin = 'N'; // Default to non-admin
        oci_bind_by_name($stmt, ':ISADMIN', $isadmin);    
        oci_bind_by_name($stmt, ':PHONENUMBER', $phonenumber);
        oci_bind_by_name($stmt, ':PASSWORDHASH', $passwordHash);

        // Execute the SQL statement and handle any errors
        if (!oci_execute($stmt)) {
            oci_free_statement($stmt);
            oci_close($conn);
            return false;
        }

        // Free the resources associated with the SQL statement and close the connection to the database
        oci_free_statement($stmt);
        oci_close($conn);

        // Return true to indicate that the user was created successfully
        return true;
    }
    
    // Define a method to check if a user exists by email
    public function doesUserExistByEmail($email) {
        // Get a connection to the database
        $conn = getDatabaseConnection();
        // Prepare a SQL statement to select the count of records from the users table where the email matches the given email
        $sql = 'SELECT COUNT(*) AS num FROM USERS WHERE EMAIL = :EMAIL';
        $stid = oci_parse($conn, $sql);
        
        // Bind the email parameter to the SQL statement
        oci_bind_by_name($stid, ':EMAIL', $email);
        
        // Execute the SQL statement and handle any errors
        if (!oci_execute($stid)) {
            return false;
        }
        
        // Fetch the result of the SQL statement into a variable
        $row = oci_fetch_array($stid, OCI_ASSOC);
            
        // Free the resources associated with the SQL statement and close the connection to the database
        oci_free_statement($stid);
        oci_close($conn);
        
        // Return true if the count is greater than 0, indicating that the user exists
        return $row && $row['NUM'] > 0;
    }

    // Define a method to get a user's details by email
    public function getUserDetailsByEmail($email) {
        // Get a connection to the database
        $conn = getDatabaseConnection();
        // Prepare a SQL statement to select a record from the users table where the email matches the given email
        $sql = 'SELECT * FROM USERS WHERE EMAIL = :EMAIL';
        $stid = oci_parse($conn, $sql);
        
        // Bind the email parameter to the SQL statement
        oci_bind_by_name($stid, ':EMAIL', $email);
        
        // Execute the SQL statement and handle any errors
        if (!oci_execute($stid)) {
            return false;
        }
        
        // Fetch the result of the SQL statement into a variable
        $row = oci_fetch_array($stid, OCI_ASSOC);
        
        // Free the resources associated with the SQL statement and close the connection to the database
        oci_free_statement($stid);
        oci_close($conn);
        
        // Return the user's details if they were found, or false otherwise
        return $row ?: false;
    }

    // Define a method to delete a user by email
    public function deleteUserByEmail($email) {
        // Get a connection to the database
        $conn = getDatabaseConnection();
        // Prepare a SQL statement to delete a record from the users table where the email matches the given email
        $sql = 'DELETE FROM USERS WHERE EMAIL = :EMAIL';
        $stid = oci_parse($conn, $sql);
        
        // Bind the email parameter to the SQL statement
        oci_bind_by_name($stid, ':EMAIL', $email);
        
        // Execute the SQL statement and handle any errors
        if (!oci_execute($stid)) {
            oci_free_statement($stid);
            oci_close($conn);
            return false;
        }
        
        // Free the resources associated with the SQL statement and close the connection to the database
        oci_free_statement($stid);
        oci_close($conn);
        // Return true to indicate that the user was deleted successfully
        return true;
    }

    // Define a method to get a user's details by ID
    public function getUserDetailsById($userId) {
        // Get a connection to the database
        $conn = getDatabaseConnection();
        // Prepare a SQL statement to select a record from the users table where the user ID matches the given user ID
        $sql = 'SELECT * FROM USERS WHERE USERID = :USERID';
        $stid = oci_parse($conn, $sql);
        
        // Bind the user ID parameter to the SQL statement
        oci_bind_by_name($stid, ':USERID', $userId);
        
        // Execute the SQL statement and handle any errors
        if (!oci_execute($stid)) {
            return false;
        }
        
        // Fetch the result of the SQL statement into a variable
        $row = oci_fetch_array($stid, OCI_ASSOC);
        
        // Free the resources associated with the SQL statement and close the connection to the database
        oci_free_statement($stid);
        oci_close($conn);
        
        // Return the user's details if they were found, or false otherwise
        return $row ?: false;
    }    
}