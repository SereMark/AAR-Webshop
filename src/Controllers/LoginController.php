<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../Middleware/AuthMiddleware.php';

class LoginController extends BaseController {
    private $usersModel;

    public function __construct() {
        parent::__construct();
        $this->usersModel = $this->loadModel('Users');
    }

    public function login() {
        checkIfAuthenticated();

        $email = sanitizeInput($_POST['email']);
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            return $this->jsonResponse(['error' => 'Both email and password are required.']);
        }

        $user = $this->usersModel->getUserDetailsByEmail($email);
        if (!$user || !password_verify($password, $user['PASSWORDHASH'])) {
            return $this->jsonResponse(['error' => 'Invalid email or password.']);
        }

        $this->startSession($user);
        return $this->jsonResponse(['redirect' => '/?info=login']);
    }
}