<?php
// Include the UsersModel class
require_once __DIR__ . '/../Models/UsersModel.php';

// Define the UserController class
class UserController {
    // Define a method to log out the user
    public function logout() {
        // Start a new session only if one hasn't been started already
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Unset all of the session variables
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session
        session_destroy();

        // Redirect to the home page with a success message
        header('Location: /?info=logout');
        exit;
    }

    // Define a method to delete the user's profile
    public function deleteProfile() {
        // Start a new session only if one hasn't been started already
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Get the user ID from the session
        $userId = $_SESSION['userid'] ?? null;
    
        // If no user is logged in, redirect to the home page
        if ($userId === null) {
            header('Location: /?info=error');
            exit;
        }
    
        // Create an instance of UsersModel to access the database
        $userModel = new UsersModel();
        // Get the user's details from the database
        $userDetails = $userModel->getUserDetailsById($userId);
    
        // If the user's details could not be retrieved, display an error message
        if ($userDetails === false) {
            echo "Unable to retrieve user details.";
            exit;
        }
    
        // Get the user's email
        $email = $userDetails['EMAIL'];
        
        // Delete the user from the database
        $deleteSuccess = $userModel->deleteUserByEmail($email);
        
        // If the user was deleted successfully, log out the user and redirect to the home page
        if ($deleteSuccess) {
            session_destroy();
            header('Location: /?info=delete');
        } else {
            // If the delete operation failed, display an error message
            echo "An error occurred while deleting the account.";
        }
        exit;
    }
}