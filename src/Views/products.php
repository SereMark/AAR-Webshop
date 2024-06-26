<!-- Include the addProduct modal -->
<?php include __DIR__ . '/addProduct.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <!-- Link to the products CSS file -->
    <link rel="stylesheet" href="/assets/css/products.css">
    <script src="/assets/js/products.js"></script>
</head>
<body>
<div class="main">

    <!-- Start of the Sidebar/Aside -->
    <aside class="sidebar">
        <!-- Title for the categories -->
        <h3>Categories</h3>
            <!-- List of categories -->
            <ul>
                <?php foreach ($categories as $category): ?>
                    <li>
                        <a href="/?category=<?php echo htmlspecialchars($category['CATEGORYID']); ?>">
                            <?php echo htmlspecialchars($category['NAME']); ?>
                        </a>
                    </li>
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

        <!-- Suggestions Section -->
        <?php if (!empty($productSuggestions)): ?>
            <div class="suggested-products-container">
                <button class="collapsible" data-target="suggested-products">
                    Suggested Products <span class="arrow">&#9650;</span>
                </button>
                <section class="product-grid suggested-products-grid collapsible-content" id="suggested-products">
                    <?php foreach ($productSuggestions as $product): ?>
                        <a href="/product?id=<?php echo htmlspecialchars($product['PRODUCTID']); ?>" class="product-link">
                            <div class="product-card">
                                <img src="/assets/images/placeholder.jpg" alt="<?php echo htmlspecialchars($product['NAME']); ?>" class="product-image">
                                <h4 class="product-name"><?php echo htmlspecialchars($product['NAME']); ?></h4>
                                <p class="product-price">$<?php echo htmlspecialchars(number_format((float)$product['PRICE'], 2, '.', '')); ?></p>
                                <p class="product-description"><?php echo htmlspecialchars($product['DESCRIPTION']); ?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </section>
            </div>
        <?php endif; ?>


        <!-- Top Category Produts Section -->
        <?php if (!empty($topCategoryProducts)): ?>
            <div class="top-category-products-container">
                <button class="collapsible" data-target="top-category-products">Top Category Products <span class="arrow">&#9650;</span></button>
                <section class="product-grid top-category-products-grid collapsible-content" id="top-category-products">
                    <?php foreach ($topCategoryProducts as $product): ?>
                        <a href="/product?id=<?php echo htmlspecialchars($product['PRODUCTID']); ?>" class="product-link">
                            <div class="product-card">
                                <img src="/assets/images/placeholder.jpg" alt="<?php echo htmlspecialchars($product['NAME']); ?>" class="product-image">
                                <h4 class="product-name"><?php echo htmlspecialchars($product['NAME']); ?></h4>
                                <p class="product-price">$<?php echo htmlspecialchars(number_format((float)$product['PRICE'], 2, '.', '')); ?></p>
                                <p class="product-description"><?php echo htmlspecialchars($product['DESCRIPTION']); ?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </section>
            </div>
        <?php endif; ?>


    <!-- Start of the Product Grid -->
    <?php if (empty($products)): ?>
        <h1 class="no-products">No products match the criteria.</h1>
    <?php else: ?>
    <!-- New Arrivals Section -->
    <div class="new-products-container">
        <button class="collapsible" data-target="new-arrivals">New Arrivals <span class="arrow">&#9650;</span></button>
        <section class="product-grid new-arrivals-grid collapsible-content" id="new-arrivals">
            <?php foreach ($newestProducts as $product): ?>
                <a href="/product?id=<?php echo htmlspecialchars($product['PRODUCTID']); ?>" class="product-link">
                    <div class="product-card">
                        <img src="/assets/images/placeholder.jpg" alt="<?php echo htmlspecialchars($product['NAME']); ?>" class="product-image">
                        <h4 class="product-name"><?php echo htmlspecialchars($product['NAME']); ?></h4>
                        <p class="product-price">$<?php echo htmlspecialchars(number_format((float)$product['PRICE'], 2, '.', '')); ?></p>
                        <p class="product-description"><?php echo htmlspecialchars($product['DESCRIPTION']); ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </section>
    </div>
    <section class="product-grid">
        <?php foreach ($products as $product): ?>
            <a href="/product?id=<?php echo htmlspecialchars($product['PRODUCTID']); ?>" class="product-link">
                <div class="product-card">
                    <img src="/assets/images/placeholder.jpg" alt="<?php echo htmlspecialchars($product['NAME']); ?>" class="product-image">
                    <h4 class="product-name"><?php echo htmlspecialchars($product['NAME']); ?></h4>
                    <p class="product-price">$<?php echo htmlspecialchars(number_format((float)$product['PRICE'], 2, '.', '')); ?></p>
                    <p class="product-description"><?php echo htmlspecialchars($product['DESCRIPTION']); ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </section>
    <?php endif; ?>
    <!-- End of the Product Grid -->
    </div>
</div>
</body>
</html>