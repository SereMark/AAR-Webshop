<?php
require_once 'BaseController.php';

class SystemController extends BaseController {
    /**
     * Checks the database connection and outputs the status as a JSON response.
     */
    public function checkDatabaseConnection() {
        require_once __DIR__ . '/../Helpers/db.php';

        if (isDatabaseConnected()) {
            $this->jsonResponse(['connected' => true]);
        } else {
            $this->jsonResponse(['connected' => false]);
        }
    }
}