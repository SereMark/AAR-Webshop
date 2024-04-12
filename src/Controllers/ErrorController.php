<?php
class ErrorController {
    /**
     * Sends a 404 Not Found header and displays the not found view.
     */
    public function showNotFound() {
        // Set the HTTP status code to 404 Not Found
        header("HTTP/1.0 404 Not Found");

        // Load and display the not found view
        require __DIR__ . '/../Views/notfound.php';
    }
}