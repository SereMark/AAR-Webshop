<?php
require_once __DIR__ . '/../Models/UsersModel.php';
require_once __DIR__ . '/../Helpers/security.php';

class RegistrationController {
    public function register() {
        $name = sanitizeInput($_POST['name']);
        $email = sanitizeInput($_POST['email']);
        $phone = sanitizeInput($_POST['phone']);
        $password = $_POST['password']; // TODO: Validate properly.
        $isAdmin = 0;

        // Check if the user already exists
        $userModel = new UsersModel();
        if ($userModel->getUserByEmail($email)) {
            // User already exists
            return "User with this email already exists.";
        }

        // Hash the password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Create the user
        $result = $userModel->createUser($name, $email, $phone, $isAdmin, $passwordHash);

        if ($result) {
            // Registration successful
            header('Location: /login');
        } else {
            // Registration failed
            return "An error occurred during registration.";
        }
    }
}