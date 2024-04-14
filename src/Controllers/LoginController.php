<?php
/**
 * Class LoginController
 * Handles user login operations
 */
class LoginController {
    private $usersModel;

    /**
     * LoginController constructor
     * Initializes UsersModel
     */
    public function __construct() {
        require_once __DIR__ . '/../Models/UsersModel.php';
        $this->usersModel = new UsersModel();
    }
    
    /**
     * Handle login request
     * Validates input and starts user session if credentials are valid
     */
    public function login() {
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
        $_SESSION['userid'] = $user['USERID'];
        $_SESSION['name'] = $user['NAME'];
        $_SESSION['email'] = $user['EMAIL'];
        $_SESSION['isadmin'] = $user['ISADMIN'];
    }
}