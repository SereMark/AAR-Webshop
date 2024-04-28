<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/assets/css/list.css">
</head>
<body>
    <main class="main-content">
        <section class="list">
            <?php if (empty($orderItems)): ?>
                <p class="empty-list">Your order list is empty.</p>
            <?php else: ?>
                <ul class="list-items">
                    <?php foreach ($orderItems as $item): ?>
                        <li class="list-item">
                            <div class="item-details">
                                <h2 class="item-name">Order ID: <?= htmlspecialchars($item['ORDERID']) ?></h2>
                                <h2 class="item-name">Total Amount: <?= htmlspecialchars($item['TOTALAMOUNT']) ?></h2>
                                <h2 class="item-name">Payment Method: <?= htmlspecialchars($item['PAYMENTMETHOD']) ?></h2>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>