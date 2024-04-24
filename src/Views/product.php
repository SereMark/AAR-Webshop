<?php
// Include the necessary models
require_once __DIR__ . '/../Models/ProductsModel.php';
require_once __DIR__ . '/../Models/ReviewsModel.php';
require_once __DIR__ . '/../Models/UsersModel.php';

// Create instances of the models
$productsModel = new ProductsModel();
$reviewsModel = new ReviewsModel();
$usersModel = new UsersModel();

// Get the product ID from the URL
$productId = $_GET['id'] ?? null;

// Use the products model to fetch product details
$product = $productsModel->fetchProductById($productId);

if ($product) {
    $productName = htmlspecialchars($product['NAME']);
    $productDescription = htmlspecialchars($product['DESCRIPTION'] ?? 'No description provided.');
    $productPrice = htmlspecialchars(number_format((float)($product['PRICE']), 2, '.', ''));

    // Use the reviews model to fetch reviews for the product
    $reviews = $reviewsModel->getReviewsByProductId($productId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $productName ?></title>
    <link rel="stylesheet" href="/assets/css/product.css">
</head>
<body>
    <header class="product-header">
        <h1><?= $productName ?></h1>
    </header>
    <div class="product-container">
        <div class="product-image-gallery">
            <img src="/assets/images/placeholder.jpg" alt="<?= $productName ?>" class="product-image">
        </div>
        <div class="product-details">
            <p><?= $productDescription ?></p>
            <p class="price">Price: $<?= $productPrice ?></p>
            <div class="button-container">
                <form action="/cart" method="post">
                    <input type="hidden" name="productid" value="<?= $productId ?>">
                    <button type="submit" class="add-to-cart-button">Add to Cart</button>
                </form>
                <div class="delete-product-button-container">
                    <button type="button" class="delete-product-button" disabled>Delete [WIP]</button>
                </div>
            </div>
        </div>
    </div>

    <div class="reviews-section">
        <h2>Customer Reviews</h2>
        <div class="sort-container">
            <label for="sort">Sort by:</label>
            <form method="GET">
                <input type="hidden" name="id" value="<?= $productId ?>">
                <input type="hidden" name="nocache" value="<?= time() ?>">
                <select name="sort" id="sort" onchange="this.form.submit()" class="sort-dropdown">
                    <option value="desc" <?= isset($_GET['sort']) && $_GET['sort'] === 'desc' ? 'selected' : '' ?>>Highest Rated</option>
                    <option value="asc" <?= isset($_GET['sort']) && $_GET['sort'] === 'asc' ? 'selected' : '' ?>>Lowest Rated</option>
                </select>
            </form>
        </div>

        <?php
        $sortOrder = $_GET['sort'] ?? 'desc';
        $reviews = $reviewsModel->getReviewsByProductId($productId, $sortOrder);
        foreach ($reviews as $review) {
            $user = $usersModel->getUserDetailsById($review['USERID']);
            $username = htmlspecialchars($user['NAME'] ?? 'Anonymous');
            $canDelete = isset($_SESSION['userid']) && $_SESSION['userid'] == $review['USERID'];
            ?>
            <div class="review">
                <div class="review-content">
                    <strong><?= $username ?></strong>
                    <p class="review-text"><?= htmlspecialchars($review['TEXT']) ?></p>
                    <p class="review-rating">Rating: <?= htmlspecialchars($review['RATING']) ?> stars</p>
                </div>
                <?php if ($canDelete): ?>
                    <div class="review-controls">
                        <form action="/delete-review" method="post">
                            <input type="hidden" name="reviewid" value="<?= $review['REVIEWID'] ?>">
                            <input type="hidden" name="productid" value="<?= $productId ?>">
                            <button type="submit" class="delete-review-button">Delete Review</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        <?php } ?>
        <div class="review-form">
        <h3>Leave a Review</h3>
        <form action="/submit-review" method="post">
            <input type="hidden" name="productid" value="<?= $productId ?>">
            <label for="rating">Rating:</label>
            <select name="rating" id="rating">
                <option value="5">5 Stars</option>
                <option value="4">4 Stars</option>
                <option value="3">3 Stars</option>
                <option value="2">2 Stars</option>
                <option value="1">1 Star</option>
            </select>
            <label for="review_text">Review:</label>
            <textarea id="review_text" name="review_text" rows="4" required></textarea>
            <button type="submit">Submit Review</button>
        </form>
        </div>
    </div>
</body>
</html>

<?php
} else {
    echo "Product not found.";
}
?>