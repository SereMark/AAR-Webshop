<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/assets/css/list.css">
    <script src="/assets/js/profile.js"></script>
</head>
<body>
    <main class="main-content">
        <section class="list">
            <?php if (empty($orders)): ?>
                <p class="empty-list">Your order list is empty.</p>
            <?php else: ?>
                <ul class="list-items">
                    <?php foreach ($orders as $order): ?>
                        <li class="list-item">
                            <div class="item-details">
                                <h2 class="item-name">Order ID: <?= htmlspecialchars($order['ORDERID']) ?></h2>
                                <p class="item-info">Total Amount: $<?= htmlspecialchars($order['TOTALAMOUNT']) ?></p>
                                <p class="item-info">Payment Method: <?= htmlspecialchars($order['PAYMENTMETHOD']) ?></p>
                                <div class="sub-items">
                                    <?php foreach ($order['items'] as $item): ?>
                                        <div class="sub-item">
                                            <span class="sub-item-name">Product: <?= htmlspecialchars($item['NAME']) ?></span>
                                            <span class="sub-item-info">Quantity: <?= htmlspecialchars($item['QUANTITY']) ?></span>
                                            <span class="sub-item-info">Price: $<?= htmlspecialchars($item['PRICE']) ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php echo $order['blobFileName'] ?>
                                <button onclick="showPdf(<?php echo $order['blob'] ?>, <?php echo $order['blobFileName'] ?>)">Invoice</button>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>