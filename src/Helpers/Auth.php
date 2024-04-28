<?php

/**
 * Starts a session for the user.
 */
function startSession($user) {
    $_SESSION['userid'] = $user['USERID'];
    $_SESSION['name'] = $user['NAME'];
    $_SESSION['email'] = $user['EMAIL'];
    $_SESSION['phonenumber'] = $user['PHONENUMBER'];
    $_SESSION['isadmin'] = $user['ISADMIN'];
}

/**
 * Function to sanitize user input
 *
 * @param string $data The raw user input
 * @return string The sanitized user input
 */
function sanitizeInput($data) {
    // Remove spaces from the beginning and end of the input
    $data = trim($data);
    // Remove backslashes from the input
    $data = stripslashes($data);
    // Convert special characters to their HTML entities to prevent XSS attacks
    $data = htmlspecialchars($data);
    return $data;
}