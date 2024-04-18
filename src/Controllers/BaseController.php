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
            $this->redirect('/');
        }
    }

    /**
     * Starts a session for the user.
     */
    protected function startSession($user) {
        $_SESSION['userid'] = $user['USERID'];
        $_SESSION['name'] = $user['NAME'];
        $_SESSION['email'] = $user['EMAIL'];
        $_SESSION['phonenumber'] = $user['PHONENUMBER'];
        $_SESSION['isadmin'] = $user['ISADMIN'];
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