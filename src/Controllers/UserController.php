<?php
require_once 'BaseController.php';

class UserController extends BaseController {
    private $usersModel;
    private $orderModel;
    private $reviewsModel;
    private $productsModel;
    private $categoriesModel;
    private $couponsModel;

    /**
     * Constructor initializes the Models.
     */
    public function __construct() {
        parent::__construct();
        $this->usersModel = $this->loadModel('Users');
        $this->orderModel = $this->loadModel('Order');
        $this->reviewsModel = $this->loadModel('Reviews');
        $this->productsModel = $this->loadModel('Products');
        $this->categoriesModel = $this->loadModel('Categories');
        $this->couponsModel = $this->loadModel('Coupons');
    }

    /**
     * Displays the user's profile or redirects if not logged in.
     */
    public function showProfile() {
        $userId = $_SESSION['userid'] ?? null;
        if (!$userId) {
            $this->redirect('/?info=LoginRequired');
        }

        $user = $this->usersModel->getUserDetailsById($userId);
        if (!$user) {
            $this->redirect('/?info=error');
        }
        $user['PASSWORDHASH'] = null;
        
        $orderCount = $this->orderModel->getOrderCountByUserId($userId);
        $reviewCount = $this->reviewsModel->getReviewCountByUserId($userId);
        $productCount = $this->productsModel->getProductCountByUserId($userId);
        $balanceCount = $this->usersModel->getBalanceByUserId($userId);

        $pageTitle = 'Profile';
        $content = __DIR__ . '/../Views/profile.php';
        // Pass the counts to the view
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
            $this->redirect('/?info=LoginRequired');
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
            $this->redirect('/profile/?info=error');
        }
    }    

    public function updatePassword() {
        $userId = $_SESSION['userid'] ?? null;
        if (!$userId) {
            $this->redirect('/?info=LoginRequired');
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
                $this->redirect('/profile/?info=error');
            }
        } else {
            $this->redirect('/profile/?info=error');
        }
    }    

    public function updateBalance() {
        $userId = $_SESSION['userid'] ?? null;
        if (!$userId) {
            $this->redirect('/?info=LoginRequired');
        }
        $balance = $_POST['balance'] ;
        $cvc =  $_POST['cvc'] ;
        $expiry_date =  $_POST['expiry_date'] ;
        $card_number = $_POST['card_number'] ;
        
    
        if ($this->usersModel->updateBalance($userId, $balance, $card_number, $cvc, $expiry_date)) {
            $_SESSION['balance'] = $balance;
            $_SESSION['card_number'] = $card_number;
            $_SESSION['cvc'] = $cvc;
            $_SESSION['expiry_date'] = $expiry_date;
            $_SESSION['userId'] = $userId;
    
            $this->redirect('/profile?info=balanceUpdated');
        } else {
            $this->redirect('/profile/?info=error');
        }
    }    

    /**
     * Deletes the user's profile based on their session ID and redirects or displays an error.
     */
    public function deleteProfile() {
        $userId = $_SESSION['userid'] ?? null;
        if (!$userId) {
            $this->redirect('/?info=LoginRequired');
        }

        $userDetails = $this->usersModel->getUserDetailsById($userId);
        if (!$userDetails) {
            $this->redirect('/profile/?info=error');
            exit;
        }

        if ($this->usersModel->deleteUserByEmail($userDetails['EMAIL'])) {
            $_SESSION = array();
            if (session_id()) {
                session_destroy();
            }        
            $this->redirect('/?info=delete');
        } else {
            $this->redirect('/profile/?info=error');
            exit;
        }
    }

    /**
     * Displays the admin dashboard if the user is an admin, otherwise redirects to the profile page.
     */
    public function showAdminDashboard() {
        $userId = $_SESSION['userid'] ?? null;
        if (!$userId) {
            $this->redirect('/?info=LoginRequired');
        }

        $user = $this->usersModel->getUserDetailsById($userId);
        if (!$user) {
            $this->redirect('/?info=error');
        }

        if ($user['ISADMIN'] != 'N') {
            $users = $this->usersModel->fetchAllUsers();
            $orders = $this->orderModel->fetchAllOrders();
            $toDeliverOrders = $this->orderModel->fetchToBeDeliveredOrders();
            $reviews = $this->reviewsModel->fetchAllReviews();
            $products = $this->productsModel->fetchProducts();
            $categories = $this->categoriesModel->fetchCategories();  
            $coupons = $this->couponsModel->fetchCoupons();
            $jsonData = $this->usersModel->fetchStatistics();

            $pageTitle = 'Admin Dashboard';
            $content = __DIR__ . '/../Views/admin_dashboard.php';
            require __DIR__ . '/../Views/layout.php';
        } else {
            $this->redirect('/profile?info=notAdmin');
        }
    }

    /**
     * Deletes the user's profile based on their session ID and redirects or displays an error.
     */
    public function deleteOne() {
        $userId = $_POST['userid'] ?? null;
        if ($userId && $this->usersModel->deleteUserById($userId)) {
            $this->redirect('/admin_dashboard?info=delete');
        } else {
            $this->redirect('/admin_dashboard/?info=error');
        }
    }

    /**
     * Sets the admin status of a user based on their user ID.
     */
    public function setAdminStatus() {
        $userId = $_POST['userid'] ?? null;
        if (!$userId) {
            $this->redirect('/admin_dashboard?info=error');
        }
    
        $user = $this->usersModel->getUserDetailsById($userId);
        $newStatus = ($user['ISADMIN'] === 'Y' ? 'N' : 'Y');
        if ($this->usersModel->setAdminStatus($userId, $newStatus)) {
            $this->redirect('/admin_dashboard?info=update');
        } else {
            $this->redirect('/admin_dashboard?info=error');
        }
    }    
}