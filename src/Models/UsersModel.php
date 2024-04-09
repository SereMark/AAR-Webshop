<?php
require_once __DIR__ . '/../Helpers/db.php';

class UsersModel {
    public function createUser($name, $email, $phonenumber, $passwordHash) {
        $conn = getDatabaseConnection();
        $sql = 'INSERT INTO users (name, email, phonenumber, isadmin, passwordhash) VALUES (:name, :email, :phonenumber, \'N\', :passwordhash)';
        $stid = oci_parse($conn, $sql);
        
        oci_bind_by_name($stid, ':name', $name);
        oci_bind_by_name($stid, ':email', $email);
        oci_bind_by_name($stid, ':phonenumber', $phonenumber);
        oci_bind_by_name($stid, ':passwordhash', $passwordHash);
        
        $result = oci_execute($stid);
        
        oci_free_statement($stid);
        oci_close($conn);
        
        return $result;
    }    
    
    public function getUserByEmail($email) {
        $conn = getDatabaseConnection();
        $sql = 'SELECT * FROM users WHERE email = :email';
        $stid = oci_parse($conn, $sql);
        
        oci_bind_by_name($stid, ':email', $email);
        
        oci_execute($stid);
        $user = oci_fetch_assoc($stid);
        
        oci_free_statement($stid);
        oci_close($conn);
        
        return $user;
    }
}