<?php
require_once __DIR__ . '/../Models/UsersModel.php';
require_once __DIR__ . '/../Helpers/security.php';

class RegistrationController {
    public function register() {
        $name = sanitizeInput($_POST['name']);
        $email = sanitizeInput($_POST['email']);
        $phone = sanitizeInput($_POST['phone']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if (empty($name) || empty($email) || empty($phone) || empty($password) || empty($confirm_password)) {
            $this->jsonResponse(['error' => 'All fields are required.']);
        }

        if ($password !== $confirm_password) {
            $this->jsonResponse(['error' => 'Passwords do not match.']);
        }

        $userModel = new UsersModel();
        if ($userModel->doesUserExistByEmail($email)) {
            $this->jsonResponse(['error' => 'A user with this email already exists.']);
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $result = $userModel->createUser($name, $email, $phone, $passwordHash);

        if ($result) {
            $this->loginAfterRegistration($email, $password);
        } else {
            $this->jsonResponse(['error' => 'Registration failed due to a server error. Please try again later.']);
        }
    }    

    private function loginAfterRegistration($email, $password) {
        $userModel = new UsersModel();
        $user = $userModel->getUserDetailsByEmail($email);

        if (is_array($user) && isset($user['PASSWORDHASH']) && password_verify($password, $user['PASSWORDHASH'])) {
            $this->startSession($user);
            $this->jsonResponse(['redirect' => '/?info=register']);
        } else {
            $this->jsonResponse(['error' => 'Login after registration failed. Please log in manually.']);
        }
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
        session_regenerate_id(true);
        $_SESSION['userid'] = $user['USERID'];
        $_SESSION['name'] = $user['NAME'];
        $_SESSION['email'] = $user['EMAIL'];
        $_SESSION['isadmin'] = $user['ISADMIN'];
    }
}