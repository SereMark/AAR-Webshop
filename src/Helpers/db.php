<?php
function getDatabaseConnection() {
    putenv('NLS_LANG=.AL32UTF8');

    $tns = "
    (DESCRIPTION =
        (ADDRESS_LIST =
            (ADDRESS = (PROTOCOL = TCP)(HOST = " . DB_HOST . ")(PORT = " . DB_PORT . "))
        )
        (CONNECT_DATA =
            (SID = " . DB_SID . ")
        )
    )";
    $conn = oci_connect(DB_USER, DB_PASS, $tns);
    if (!$conn) {
        $m = oci_error();
        throw new Exception('Cannot connect to database: ' . $m['message']);
    }
    return $conn;
}