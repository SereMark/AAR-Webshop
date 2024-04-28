<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/assets/css/list.css">
    <script src="/assets/js/reviews.js"></script>
</head>
<body>
    <main class="main-content">
        <section class="list">
            <?php if (empty($reviews)): ?>
                <p class="empty-list">Your review list is empty.</p>
            <?php else: ?>
                <form action="/delete-all-reviews" method="post" id="delete-all-reviews-form">
                    <button type="button" class="danger-link" id="delete-all-btn">Delete All Reviews</button>
                </form>
                <ul class="list-items">
                    <?php foreach ($reviews as $review): ?>
                        <li class="list-item">
                            <div class="item-details">
                                <h2 class="item-name"><?= htmlspecialchars($review['PRODUCT_NAME']) ?></h2>
                                <p><?= htmlspecialchars($review['TEXT']) ?></p>
                                <p>Rating: <?= str_repeat('★', $review['RATING']) ?></p>
                            </div>
                            <form class="delete-form" action="/delete-review" method="post">
                                <input type="hidden" name="reviewid" value="<?= $review['REVIEWID'] ?>">
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>