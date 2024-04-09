<?php
require_once __DIR__ . '/../Models/UsersModel.php';
require_once __DIR__ . '/../Helpers/security.php';

class LoginController {
    public function login() {
        $email = sanitizeInput($_POST['email']);
        $password = $_POST['password']; // TODO: Validate properly.

        $userModel = new UsersModel();
        $user = $userModel->getUserByEmail($email);

        if ($user && password_verify($password, $user['PASSWORDHASH'])) {
            // Password is correct, start a new session
            session_start();
            $_SESSION['userid'] = $user['USERID'];
            $_SESSION['isadmin'] = $user['ISADMIN'];

            // Redirect to the user's profile or dashboard
            header('Location: /profile');
            exit();
        } else {
            // Authentication failed
            return "Login failed. Please check your email and password.";
        }
    }
}