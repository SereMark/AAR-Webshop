<?php
require_once __DIR__ . '/../Models/UsersModel.php';
require_once __DIR__ . '/../Helpers/security.php';

class LoginController {
    public function login() {
        $email = sanitizeInput($_POST['email']);
        $password = $_POST['password'];

        $userModel = new UsersModel();
        $user = $userModel->getUserDetailsByEmail($email);

        if (is_array($user) && isset($user['PASSWORDHASH']) && password_verify($password, $user['PASSWORDHASH'])) {
            session_start();
            $_SESSION['userid'] = $user['USERID'];
            $_SESSION['name'] = $user['NAME'];
            $_SESSION['email'] = $user['EMAIL'];
            $_SESSION['isadmin'] = $user['ISADMIN'];

            header('Location: /?success=login');
            exit;
        } else {
            echo "Login failed. Please check your email and password.";
            exit;
        }
    }
}