<?php
require_once 'BaseController.php';

class UserController extends BaseController {
    private $usersModel;

    /**
     * Constructor initializes the UsersModel.
     */
    public function __construct() {
        parent::__construct();  // Initialize the BaseController which handles session start
        $this->usersModel = $this->loadModel('Users');
    }

    /**
     * Displays the user's profile or redirects if not logged in.
     */
    public function showProfile() {
        $userId = $_SESSION['userid'] ?? null;
        if (!$userId) {
            $this->redirect('/login');
        }

        $user = $this->usersModel->getUserDetailsById($userId);
        if (!$user) {
            $this->redirect('/');
        }
        
        $pageTitle = 'Profile';
        $content = __DIR__ . '/../Views/profile.php';
        require __DIR__ . '/../Views/layout.php';
    }

    /**
     * Logs out the user and redirects to the homepage.
     */
    public function logout() {
        $_SESSION = array();
        if (session_id()) { // Check if a session is active before destroying
            session_destroy();
        }
        $this->redirect('/?info=logout');
    }

    /**
     * Deletes the user's profile based on their session ID and redirects or displays an error.
     */
    public function deleteProfile() {
        $userId = $_SESSION['userid'] ?? null;
        if (!$userId) {
            $this->redirect('/');
        }

        $userDetails = $this->usersModel->getUserDetailsById($userId);
        if (!$userDetails) {
            echo "Failed to retrieve user details.";
            exit;
        }

        if ($this->usersModel->deleteUserByEmail($userDetails['EMAIL'])) {
            $_SESSION = array();
            if (session_id()) { // Check if a session is active before destroying
                session_destroy();
            }        
            $this->redirect('/?info=delete');
        } else {
            echo "Failed to delete the profile.";
            exit;
        }
    }    
}