<?php
// Start a new session only if one hasn't been started already
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/**
 * Function to check if the user is authenticated
 *
 * If the user is authenticated (i.e., the 'userid' session variable is set),
 * the user is redirected to the home page.
 */
function checkIfAuthenticated() {
    // Check if the 'userid' session variable is set
    if (isset($_SESSION['userid'])) {
        // If 'userid' is set, redirect the user to the home page
        header('Location: /');
        // Terminate the script
        exit();
    }
}