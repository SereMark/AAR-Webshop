<?php
// Function to establish a connection with the database
function getDatabaseConnection() {
    // Set the NLS_LANG environment variable to AL32UTF8
    putenv('NLS_LANG=.AL32UTF8');

    // Define the TNS data used to connect to the Oracle database
    $tns = "
    (DESCRIPTION =
        (ADDRESS_LIST =
            (ADDRESS = (PROTOCOL = TCP)(HOST = " . DB_HOST . ")(PORT = " . DB_PORT . "))
        )
        (CONNECT_DATA =
            (SID = " . DB_SID . ")
        )
    )";
    // Attempt to establish a connection with the Oracle database
    $conn = oci_connect(DB_USER, DB_PASS, $tns);
    // If the connection fails, throw an exception
    if (!$conn) {
        $m = oci_error();
        throw new Exception('Cannot connect to database: ' . $m['message']);
    }
    // Return the connection
    return $conn;
}

// Function to check if a connection with the database can be established
function isDatabaseConnected() {
    try {
        // Attempt to establish a connection with the database
        $conn = getDatabaseConnection();
        // Close the connection
        $conn = null;
        // If the connection was successful, return true
        return true;
    } catch (Exception $e) {
        // If the connection failed, return false
        return false;
    }
}