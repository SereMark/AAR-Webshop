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

        if ($password !== $confirm_password) {
            echo "Passwords do not match.";
            exit;
        }

        $userModel = new UsersModel();

        if ($userModel->doesUserExistByEmail($email)) {
            echo "User with this email already exists.";
            exit;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $result = $userModel->createUser($name, $email, $phone, $passwordHash);

        if ($result) {
            $this->loginAfterRegistration($email, $password);
        } else {
            echo "An error occurred during registration.";
            exit;
        }
    }

    private function loginAfterRegistration($email, $password) {
        $userModel = new UsersModel();
        $user = $userModel->getUserDetailsByEmail($email);

        if (is_array($user) && isset($user['PASSWORDHASH']) && password_verify($password, $user['PASSWORDHASH'])) {
            session_start();
            $_SESSION['userid'] = $user['USERID'];
            $_SESSION['name'] = $user['NAME'];
            $_SESSION['email'] = $user['EMAIL'];
            $_SESSION['isadmin'] = $user['ISADMIN'];

            header('Location: /?success=register');
            exit;
        } else {
            echo "An error occurred during the login process.";
            exit;
        }
    }
}