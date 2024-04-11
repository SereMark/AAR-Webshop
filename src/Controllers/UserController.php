<?php
require_once __DIR__ . '/../Models/UsersModel.php';

class UserController {
    public function logout() {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Unset all of the session variables.
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie.
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();

        // Redirect to the home page with a success message
        header('Location: /?info=logout');
        exit;
    }

    public function deleteProfile() {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $userId = $_SESSION['userid'] ?? null;
    
        if ($userId === null) {
            // No user is logged in, redirect to the home page
            header('Location: /?info=error');
            exit;
        }
    
        // Instance of UsersModel to access the database
        $userModel = new UsersModel();
        $userDetails = $userModel->getUserDetailsById($userId);
    
        if ($userDetails === false) {
            // Handle the case where user details could not be retrieved
            echo "Unable to retrieve user details.";
            exit;
        }
    
        $email = $userDetails['EMAIL'];
        
        // Proceed to delete user by email
        $deleteSuccess = $userModel->deleteUserByEmail($email);
        
        if ($deleteSuccess) {
            // User was deleted successfully, logout the user
            session_destroy();
            header('Location: /?info=delete');
        } else {
            // Handle the case where the delete operation fails
            echo "An error occurred while deleting the account.";
        }
        exit;
    }
    
}