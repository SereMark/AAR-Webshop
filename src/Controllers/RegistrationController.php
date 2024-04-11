<?php
require_once __DIR__ . '/../Models/UsersModel.php';
require_once __DIR__ . '/../Helpers/security.php';

class RegistrationController {
    public function register() {
        $name = sanitizeInput($_POST['name']);
        $email = sanitizeInput($_POST['email']);
        $phone = sanitizeInput($_POST['phone']);
        $password = $_POST['password'];

        $userModel = new UsersModel();

        if ($userModel->doesUserExistByEmail($email)) {
            echo "User with this email already exists.";
            exit;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $result = $userModel->createUser($name, $email, $phone, $passwordHash);

        if ($result) {
            header('Location: /');
            exit;
        } else {
            echo "An error occurred during registration.";
            exit;
        }
    }
}