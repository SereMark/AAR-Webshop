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

    <!-- Start of the Product Grid -->
    <?php if (empty($products)): ?>
        <h1 class="no-products">No products match the criteria.</h1>
    <?php else: ?>
    <div class="new-products-container">
        <h2>New Arrivals</h2>
        <section class="product-grid new-arrivals-grid">
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