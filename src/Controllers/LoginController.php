<?php
require_once __DIR__ . '/../Models/UsersModel.php';
require_once __DIR__ . '/../Helpers/security.php';

class LoginController {
    public function login() {
        $email = sanitizeInput($_POST['email']);
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            $this->jsonResponse(['error' => 'Both email and password are required.']);
        }

        $userModel = new UsersModel();
        $user = $userModel->getUserDetailsByEmail($email);

        if (!$user || !isset($user['PASSWORDHASH']) || !password_verify($password, $user['PASSWORDHASH'])) {
            $this->jsonResponse(['error' => 'Invalid email or password. Please try again.']);
        }

        $this->startSession($user);
        $this->jsonResponse(['redirect' => '/?info=login']);
    }

    private function jsonResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    private function startSession($user) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['userid'] = $user['USERID'];
        $_SESSION['name'] = $user['NAME'];
        $_SESSION['email'] = $user['EMAIL'];
        $_SESSION['isadmin'] = $user['ISADMIN'];
    }
}