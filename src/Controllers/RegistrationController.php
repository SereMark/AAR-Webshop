<?php
// Include the necessary files
require_once __DIR__ . '/../Models/UsersModel.php';
require_once __DIR__ . '/../Helpers/security.php';

// Define the RegistrationController class
class RegistrationController {
    // Define the register method
    public function register() {
        // Sanitize the input data
        $name = sanitizeInput($_POST['name']);
        $email = sanitizeInput($_POST['email']);
        $phone = sanitizeInput($_POST['phone']);
        // Passwords are not sanitized to allow special characters
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Check if any of the fields are empty
        if (empty($name) || empty($email) || empty($phone) || empty($password) || empty($confirm_password)) {
            $this->jsonResponse(['error' => 'All fields are required.']);
        }

        // Check if the passwords match
        if ($password !== $confirm_password) {
            $this->jsonResponse(['error' => 'Passwords do not match.']);
        }

        // Create a new UsersModel object
        $userModel = new UsersModel();
        // Check if a user with the same email already exists
        if ($userModel->doesUserExistByEmail($email)) {
            $this->jsonResponse(['error' => 'A user with this email already exists.']);
        }

        // Hash the password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        // Create the user
        $result = $userModel->createUser($name, $email, $phone, $passwordHash);

        // If the user was created successfully, log them in
        if ($result) {
            $this->loginAfterRegistration($email, $password);
        } else {
            $this->jsonResponse(['error' => 'Registration failed due to a server error. Please try again later.']);
        }
    }    

    // Define the loginAfterRegistration method
    private function loginAfterRegistration($email, $password) {
        // Create a new UsersModel object
        $userModel = new UsersModel();
        // Get the user details by email
        $user = $userModel->getUserDetailsByEmail($email);

        // If the user exists and the password is correct, start a session
        if (is_array($user) && isset($user['PASSWORDHASH']) && password_verify($password, $user['PASSWORDHASH'])) {
            $this->startSession($user);
            $this->jsonResponse(['redirect' => '/?info=register']);
        } else {
            $this->jsonResponse(['error' => 'Login after registration failed. Please log in manually.']);
        }
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
        // Regenerate the session ID to prevent session fixation attacks
        session_regenerate_id(true);
        // Store the user data in the session
        $_SESSION['userid'] = $user['USERID'];
        $_SESSION['name'] = $user['NAME'];
        $_SESSION['email'] = $user['EMAIL'];
        $_SESSION['isadmin'] = $user['ISADMIN'];
    }
}