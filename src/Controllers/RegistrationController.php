<?php
/**
 * Class RegistrationController
 * Handles user registration operations
 */
class RegistrationController {
    private $usersModel;

    /**
     * RegistrationController constructor
     * Initializes UsersModel
     */
    public function __construct() {
        require_once __DIR__ . '/../Models/UsersModel.php';
        $this->usersModel = new UsersModel();
    }

    /**
     * Show the registration form
     */
    public function showRegistrationForm() {
        $content = __DIR__ . '/../Views/register.php'; 
        require __DIR__ . '/../Views/layout.php';
    }

    /**
     * Handle registration request
     * Validates input and creates a new user if input is valid
     */
    public function register() {
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

    /**
     * Log in user after successful registration
     * @param string $email - user's email
     * @param string $password - user's password
     */
    private function loginAfterRegistration($email, $password) {
        $user = $this->usersModel->getUserDetailsByEmail($email);
        if ($user && password_verify($password, $user['PASSWORDHASH'])) {
            $this->startSession($user);
            return $this->jsonResponse(['redirect' => '/?info=register']);
        } else {
            return $this->jsonResponse(['error' => 'Login after registration failed. Please log in manually.']);
        }
    }

    /**
     * Send JSON response
     * @param array $data - data to be sent in the response
     */
    private function jsonResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Start user session
     * @param array $user - user data
     */
    private function startSession($user) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_regenerate_id(true);
        $_SESSION['userid'] = $user['USERID'];
        $_SESSION['name'] = $user['NAME'];
        $_SESSION['email'] = $user['EMAIL'];
        $_SESSION['isadmin'] = $user['ISADMIN'];
    }
}