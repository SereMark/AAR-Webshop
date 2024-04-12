<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/assets/css/cart.css">
</head>
<body>
    <main class="main-content">
        <section class="cart">
            <?php if (empty($cartItems)): ?>
                <p class="empty-cart">Your cart is empty.</p>
            <?php else: ?>
                <ul class="cart-items">
                    <?php foreach ($cartItems as $item): ?>
                        <li class="cart-item">
                            <article class="item-details">
                                <h2 class="item-name"><?= htmlspecialchars($item['productname']) ?></h2>
                                <p class="item-price">Price: <?= htmlspecialchars($item['price']) ?></p>
                            </article>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>