<?php
// Include the necessary models
require_once __DIR__ . '/../Models/ProductsModel.php';
require_once __DIR__ . '/../Models/ReviewsModel.php';

// Create instances of the models
$productsModel = new ProductsModel();
$reviewsModel = new ReviewsModel();

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
                <form action="/api/cart" method="post">
                    <input type="hidden" name="productid" value="<?= $productId ?>">
                    <button type="submit" class="add-to-cart-button">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>

    <div class="reviews-section">
        <h2>Customer Reviews</h2>
        <?php foreach ($reviews as $review) { ?>
            <div class="review">
                <p class="review-text"><?= htmlspecialchars($review['TEXT']) ?></p>
                <p class="review-rating">Rating: <?= htmlspecialchars($review['RATING']) ?> stars</p>
            </div>
        <?php } ?>
        <div class="review-form">
        <h3>Leave a Review</h3>
        <form action="/api/submit-review" method="post">
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