<?php
require_once 'BaseController.php';

class UserController extends BaseController {
    private $usersModel;

    /**
     * Constructor initializes the UsersModel.
     */
    public function __construct() {
        parent::__construct();
        $this->usersModel = $this->loadModel('Users');
    }

    /**
     * Displays the user's profile or redirects if not logged in.
     */
    public function showProfile() {
        $userId = $_SESSION['userid'] ?? null;
        if (!$userId) {
            $this->redirect('/');
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
        if (session_id()) {
            session_destroy();
        }
        $this->redirect('/?info=logout');
    }

    public function updateProfile() {
        $userId = $_SESSION['userid'] ?? null;
        if (!$userId) {
            $this->redirect('/');
        }
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phoneNumber = $_POST['phoneNumber'] ?? '';
    
        if ($this->usersModel->updateUser($userId, $name, $email, $phoneNumber)) {
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['phonenumber'] = $phoneNumber;
    
            $this->redirect('/profile?info=profileUpdated');
        } else {
            echo "Update failed.";
        }
    }    

    public function updatePassword() {
        $userId = $_SESSION['userid'] ?? null;
        if (!$userId) {
            $this->redirect('/');
        }
        $currentPassword = $_POST['currentPassword'] ?? '';
        $newPassword = $_POST['newPassword'] ?? '';
    
        $userDetails = $this->usersModel->getUserDetailsById($userId);
        if (password_verify($currentPassword, $userDetails['PASSWORDHASH'])) {
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            if ($this->usersModel->updatePassword($userId, $newPasswordHash)) {
                $_SESSION = array();
                session_destroy();
                $this->redirect('/?info=passwordChangedPleaseLoginAgain');
            } else {
                echo "Password update failed.";
            }
        } else {
            echo "Incorrect current password.";
        }
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
            if (session_id()) {
                session_destroy();
            }        
            $this->redirect('/?info=delete');
        } else {
            echo "Failed to delete the profile.";
            exit;
        }
    }    
}