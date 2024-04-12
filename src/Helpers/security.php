<?php

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
    // Return the sanitized input
    return $data;
}