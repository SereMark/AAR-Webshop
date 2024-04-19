<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../Middleware/AuthMiddleware.php';
require_once __DIR__ . '/../Helpers/Auth.php';

class RegistrationController extends BaseController {
    private $usersModel;

    public function __construct() {
        parent::__construct();
        $this->usersModel = $this->loadModel('Users');
    }

    public function register() {
        checkIfAuthenticated();

        $name = sanitizeInput($_POST['name']);
        $email = sanitizeInput($_POST['email']);
        $phone = sanitizeInput($_POST['phone']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if (empty($name) || empty($email) || empty($phone) || empty($password) || empty($confirm_password)) {
            return $this->jsonResponse(['error' => 'All fields are required.']);
        }

        if ($password !== $confirm_password) {
            return $this->jsonResponse(['error' => 'Passwords do not match.']);
        }

        if ($this->usersModel->doesUserExistByEmail($email)) {
            return $this->jsonResponse(['error' => 'A user with this email already exists.']);
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        if ($this->usersModel->createUser($name, $email, $phone, $passwordHash)) {
            $this->loginAfterRegistration($email, $password);
        } else {
            return $this->jsonResponse(['error' => 'Registration failed. Please try again.']);
        }
    }

    private function loginAfterRegistration($email, $password) {
        $user = $this->usersModel->getUserDetailsByEmail($email);
        if ($user && password_verify($password, $user['PASSWORDHASH'])) {
            startSession($user);
            return $this->jsonResponse(['redirect' => '/?info=register']);
        } else {
            return $this->jsonResponse(['error' => 'Login after registration failed. Please log in manually.']);
        }
    }
}