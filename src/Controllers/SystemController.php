<?php
class SystemController {
    /**
     * Checks the database connection and outputs the status as a JSON response.
     */
    public function checkDatabaseConnection() {
        require_once __DIR__ . '/../Helpers/db.php';

        header('Content-Type: application/json');  // Ensure the content type is set to JSON
        
        // Check if the connection is successful
        if (isDatabaseConnected()) {
            echo json_encode(['connected' => true]);
        } else {
            echo json_encode(['connected' => false]);
        }
        
        exit;  // Ensure no further processing occurs
    }
}