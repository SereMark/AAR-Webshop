<?php
class UserController {
    private $usersModel;

    /**
     * Constructor initializes the UsersModel.
     */
    public function __construct() {
        require_once __DIR__ . '/../Models/UsersModel.php';
        $this->usersModel = new UsersModel();
    }

    /**
     * Displays the user's profile or redirects if not logged in.
     */
    public function showProfile() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }        $userId = $_SESSION['userid'] ?? null;
        if (!$userId) {
            header('Location: /login');
            exit;
        }

        $user = $this->usersModel->getUserDetailsById($userId);
        if (!$user) {
            header('Location: /');
            exit;
        }
        
        $pageTitle = 'Profile';
        $content = __DIR__ . '/../Views/profile.php';
        require __DIR__ . '/../Views/layout.php';
    }

    /**
     * Logs out the user and redirects to the homepage.
     */
    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }        
        
        $_SESSION = array();
        session_destroy();
        header('Location: /?info=logout');
        exit;
    }

    /**
     * Deletes the user's profile based on their session ID and redirects or displays an error.
     */
    public function deleteProfile() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }        $userId = $_SESSION['userid'] ?? null;

        if (!$userId) {
            header('Location: /');
            exit;
        }

        $userDetails = $this->usersModel->getUserDetailsById($userId);
        if (!$userDetails) {
            echo "Failed to retrieve user details.";
            exit;
        }

        if ($this->usersModel->deleteUserByEmail($userDetails['EMAIL'])) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }        
            
            $_SESSION = array();
            session_destroy();
            header('Location: /?info=delete');
            exit;
        } else {
            echo "Failed to delete the profile.";
            exit;
        }
    }    
}