<?php
class BaseController {
    /**
     * Constructor that starts session if not already started.
     */
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Redirects to a given path.
     */
    protected function redirect($path) {
        header("Location: $path");
        exit;
    }

    /**
     * Sends a JSON response to the client.
     */
    protected function jsonResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Ensures the user is logged in, otherwise redirects.
     */
    protected function ensureLoggedIn() {
        if (!isset($_SESSION['userid'])) {
            $this->redirect('/?info=LoginRequired');
        }
    }

    /**
     * Loads a model.
     */
    protected function loadModel($model) {
        require_once __DIR__ . "/../Models/{$model}Model.php";
        $modelClass = $model . 'Model';
        return new $modelClass();
    }
}