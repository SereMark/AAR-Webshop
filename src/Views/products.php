<!-- Include the addProduct modal -->
<?php include __DIR__ . '/addProduct.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <!-- Link to the products CSS file -->
    <link rel="stylesheet" href="/assets/css/products.css">
</head>
<body>
<div class="main">

    <!-- Start of the Sidebar/Aside -->
    <aside class="sidebar">
        <!-- Title for the categories -->
        <h3>Categories</h3>
        <!-- List of categories -->
        <ul>
            <?php
            // Loop through each category
            foreach ($categories as $category):
                // Get the name of the category
                $categoryName = $category['NAME'];
            ?>
                <!-- Display the category name -->
                <li><a href="#"><?php echo htmlspecialchars($categoryName); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </aside>
    <!-- End of the Sidebar/Aside -->

    <!-- Start of the Product Container -->
    <div class="product-container">
    <!-- Button to add new product -->
    <div class="add-product-button">
        <?php
        // Check if the user is logged in
        if (isset($_SESSION['userid'])):
        ?>
            <button onclick="showModal('productAddModal')" class="btn btn-primary">Add a New Product!</button>
        <?php else: ?>
            <button disabled class="btn btn-primary btn-disabled">Login to Add a New Product!</button>
        <?php endif; ?>
    </div>

    <!-- Start of the Product Grid -->
    <section class="product-grid">
        <?php
        // Include the ProductsModel
        require_once __DIR__ . '/../Models/ProductsModel.php';

        // Create a new ProductsModel
        $productsModel = new ProductsModel();
        // Fetch the products
        $products = $productsModel->fetchProducts();

        // Loop through each product
        foreach ($products as $product):
            // Get the product ID, name, price, and description
            $productId = $product['PRODUCTID'] ?? 0; // Ensure there is a unique ID for each product
            $name = $product['NAME'] ?? 'Name not set';
            $price = number_format((float)($product['PRICE'] ?? 0), 2, '.', '');
            $description = $product['DESCRIPTION'] ?? 'No description provided.';
        ?>
            <!-- Anchor tag added around the product card -->
            <a href="/product?id=<?php echo htmlspecialchars($productId); ?>" class="product-link">
                <div class="product-card">
                    <img src="assets/images/placeholder.jpg" alt="<?php echo htmlspecialchars($name); ?>" class="product-image">
                    <h4 class="product-name"><?php echo htmlspecialchars($name); ?></h4>
                    <p class="product-price">$<?php echo htmlspecialchars($price); ?></p>
                    <p class="product-description"><?php echo htmlspecialchars($description); ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </section>
    <!-- End of the Product Grid -->
    </div>
</div>
</body>
</html>