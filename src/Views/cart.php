<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/assets/css/list.css">
</head>
<body>
    <main class="main-content">
        <section class="list">
            <?php if (empty($cartItems)): ?>
                <p class="empty-list">Your cart is empty.</p>
            <?php else: ?>
                <ul class="list-items">
                    <?php 
                    $totalPrice = 0;
                    foreach ($cartItems as $item): 
                        $totalPrice += $item['price'];
                    ?>
                    <li class="list-item">
                        <div class="item-details">
                            <h2 class="item-name"><?= htmlspecialchars($item['productname']) ?></h2>
                            <p class="item-info">Price: <?= htmlspecialchars($item['price']) ?>$</p>
                        </div>
                        <form class="delete-form" action="/cart/delete" method="post">
                            <input type="hidden" name="cartitemid" value="<?= $item['cartitemid'] ?>">
                            <button type="submit" class="delete-btn">Remove</button>
                        </form>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <form action="/checkout" method="post", class="confirm-container">
                    <p class="item-info">Total Price: <?= $totalPrice ?>$</p>
                    <button type="submit" class="confirm-btn">Checkout</button>
                </form>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>