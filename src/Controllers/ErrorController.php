<?php
require_once 'BaseController.php';

class ErrorController extends BaseController {
    /**
     * Sends a 404 Not Found header and displays the not found view.
     */
    public function showNotFound() {
        header("HTTP/1.0 404 Not Found");
        require __DIR__ . '/../Views/notfound.php';
    }
}