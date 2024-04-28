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
                        $totalPrice += $item['price'] * $item['quantity'];
                    ?>
                    <li class="list-item">
                        <div class="item-details">
                            <span class="item-name"><?= htmlspecialchars($item['productname']) ?></span>
                            <form action="/cart/update" method="post" style="display: flex; align-items: center;">
                                <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" class="quantity-field">
                                <input type="hidden" name="cartitemid" value="<?= $item['cartitemid'] ?>">
                                <button type="submit" class="update-btn">Update</button>
                            </form>
                            <span class="item-price">$<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                        </div>
                        <form class="delete-form" action="/cart/delete" method="post">
                            <input type="hidden" name="cartitemid" value="<?= $item['cartitemid'] ?>">
                            <button type="submit" class="delete-btn">Remove</button>
                        </form>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <form action="/checkout" method="post" class="confirm-container">
                    <p class="item-info">Total Price: $<?= number_format($totalPrice, 2) ?></p>
                    <button type="submit" class="confirm-btn">Checkout</button>
                </form>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>