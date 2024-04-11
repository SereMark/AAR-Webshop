<?php
$router = new Router();

$router->get('/', function () {
    $pageTitle = "Products";
    $content = __DIR__ . '/../Views/products.php';
    require __DIR__ . '/../Views/layout.php';
});

$router->get('/api/login', function () {
    $content = __DIR__ . '/../Views/login.php';
    require __DIR__ . '/../Views/layout.php';
});

$router->post('/api/login', function () {
    $controller = new LoginController();
    $controller->login();
});

$router->get('/api/register', function () {
    $content = __DIR__ . '/../Views/register.php';
    require __DIR__ . '/../Views/layout.php';
});

$router->post('/api/register', function () {
    $controller = new RegistrationController();
    $controller->register();
});

$router->get('/api/profile', function () {
    $pageTitle = "Profile";
    $content = __DIR__ . '/../Views/profile.php';
    require __DIR__ . '/../Views/layout.php';
});

$router->get('/logout', function () {
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
    header('Location: /?success=logout');
    exit;
});

$router->get('/delete-profile', function () {
    // Here you should verify that the user is logged in and get their email address
    // For demonstration, assume the user's email is stored in $_SESSION['email']
    session_start();
    $email = $_SESSION['email'] ?? null;

    if ($email === null) {
        // Handle the case where the user is not logged in or email is not in session
        header('Location: /');
        exit;
    }

    $userModel = new UsersModel();
    $deleteSuccess = $userModel->deleteUserByEmail($email);

    if ($deleteSuccess) {
        // Log the user out and redirect them to the homepage
        session_destroy();
        header('Location: /');
    } else {
        // Handle the case where the delete operation fails
        echo "An error occurred while deleting the account.";
    }
    exit;
});

$router->get('/api/check-db-connection', function () {
    header('Content-Type: application/json');
    echo json_encode(['connected' => isDatabaseConnected()]);
    exit;
});

$router->setNotFoundHandler(function ($router) {
    header('HTTP/1.0 error Not Found');
    require __DIR__ . '/../Views/notfound.php';
});

return $router;