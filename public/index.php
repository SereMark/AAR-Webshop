<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product List</title>
    <link rel="stylesheet" href="assets/css/shared.css">
    <link rel="stylesheet" href="assets/css/landing-page.css">
</head>
<body>

<?php
require_once __DIR__ . '/../src/Helpers/security.php';
require_once __DIR__ . '/../src/Controllers/LoginController.php';
require_once __DIR__ . '/../src/Controllers/RegistrationController.php';
require_once __DIR__ . '/../src/Router/Router.php';

$router = require_once __DIR__ . '/../src/Router/routes.php';

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->dispatch($method, $path);
?>

<!-- Navigation Bar -->
<nav class="header">
    <div class="container">
        <img src="assets/images/Isten.png" alt="Webshop Logo" class="header-logo">
        <div class="search-container">
            <input type="text" placeholder="Search products..." class="search-input">
            <button type="submit" class="search-button">Search</button>
        </div>
        <div class="header-right">
            <a href="/login" class="btn btn-secondary">Login</a>
            <a href="/register" class="btn btn-primary">Register</a>
        </div>
    </div>
</nav>

<!-- Main Content Area -->
<div class="main">

    <!-- Sidebar/Aside -->
    <aside class="sidebar">
        <h3>Categories</h3>
        <ul>
            <?php
            require_once __DIR__ . '/../src/Models/CategoriesModel.php';

            $categoriesModel = new CategoriesModel();
            $categories = $categoriesModel->fetchCategories();

            foreach ($categories as $category):
                $categoryName = $category['NAME'];
            ?>
                <li><a href="#"><?php echo htmlspecialchars($categoryName); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </aside>

    <!-- Product Grid -->
    <section class="product-grid">
        <?php
        require_once __DIR__ . '/../src/Models/ProductsModel.php';

        $productsModel = new ProductsModel();
        $products = $productsModel->fetchProducts();

        foreach ($products as $product):
            $name = $product['NAME'] ?? 'Name not set';
            $price = number_format((float)($product['PRICE'] ?? 0), 2, '.', '');
            $description = $product['DESCRIPTION'] ?? 'No description provided.';
        ?>
            <div class="product-card">
                <img src="path_to_product_image.jpg" alt="<?php echo htmlspecialchars($name); ?>" class="product-image">
                <h4 class="product-name"><?php echo htmlspecialchars($name); ?></h4>
                <p class="product-price">$<?php echo htmlspecialchars($price); ?></p>
                <p class="product-description"><?php echo htmlspecialchars($description); ?></p>
            </div>
        <?php endforeach; ?>
    </section>

</div>

<!-- Footer -->
<footer class="footer">
    <p>© 2024 Webshop. All rights reserved.</p>
</footer>

</body>
</html>