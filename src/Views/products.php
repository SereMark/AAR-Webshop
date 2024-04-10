<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/assets/css/products.css">
</head>
<body>
<div class="main">

    <!-- Sidebar/Aside -->
    <aside class="sidebar">
        <h3>Categories</h3>
        <ul>
            <?php
            require_once __DIR__ . '/../Models/CategoriesModel.php';

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
        require_once __DIR__ . '/../Models/ProductsModel.php';

        $productsModel = new ProductsModel();
        $products = $productsModel->fetchProducts();

        foreach ($products as $product):
            $name = $product['NAME'] ?? 'Name not set';
            $price = number_format((float)($product['PRICE'] ?? 0), 2, '.', '');
            $description = $product['DESCRIPTION'] ?? 'No description provided.';
        ?>
            <div class="product-card">
                <img src="assets/images/placeholder.jpg" alt="<?php echo htmlspecialchars($name); ?>" class="product-image">
                <h4 class="product-name"><?php echo htmlspecialchars($name); ?></h4>
                <p class="product-price">$<?php echo htmlspecialchars($price); ?></p>
                <p class="product-description"><?php echo htmlspecialchars($description); ?></p>
            </div>
        <?php endforeach; ?>
    </section>

</div>
</body>