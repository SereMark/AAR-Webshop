<?php
// Include the necessary files
require_once __DIR__ . '/../Models/UsersModel.php';
require_once __DIR__ . '/../Helpers/security.php';

// Define the LoginController class
class LoginController {
    // Define the login method
    public function login() {
        // Sanitize the input data
        $email = sanitizeInput($_POST['email']);
        // Passwords are not sanitized to allow special characters
        $password = $_POST['password'];

        // Check if any of the fields are empty
        if (empty($email) || empty($password)) {
            $this->jsonResponse(['error' => 'Both email and password are required.']);
        }

        // Create a new UsersModel object
        $userModel = new UsersModel();
        // Get the user details by email
        $user = $userModel->getUserDetailsByEmail($email);

        // If the user doesn't exist or the password is incorrect, return an error
        if (!$user || !isset($user['PASSWORDHASH']) || !password_verify($password, $user['PASSWORDHASH'])) {
            $this->jsonResponse(['error' => 'Invalid email or password. Please try again.']);
        }

        // Start a session and store the user data in it
        $this->startSession($user);
        // Redirect the user to the home page with a login info message
        $this->jsonResponse(['redirect' => '/?info=login']);
    }

    // Define the jsonResponse method
    private function jsonResponse($data) {
        // Set the content type to JSON
        header('Content-Type: application/json');
        // Encode the data as JSON and output it
        echo json_encode($data);
        // Stop script execution
        exit;
    }

    // Define the startSession method
    private function startSession($user) {
        // Start a session if one isn't already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // Store the user data in the session
        $_SESSION['userid'] = $user['USERID'];
        $_SESSION['name'] = $user['NAME'];
        $_SESSION['email'] = $user['EMAIL'];
        $_SESSION['isadmin'] = $user['ISADMIN'];
    }
}