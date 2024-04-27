<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/assets/css/list.css">
</head>
<body>
    <main class="main-content">
        <section class="list">
            <?php if (empty($products)): ?>
                <p class="empty-list">Your product list is empty.</p>
            <?php else: ?>
                <ul class="list-items">
                    <?php foreach ($products as $item): ?>
                        <li class="list-item">
                            <div class="item-details">
                                <h2 class="item-name"><?= htmlspecialchars($item['NAME']) ?></h2>
                                <p class="item-info">Price: <?= htmlspecialchars($item['PRICE']) ?>$</p>
                            </div>
                            <form class="delete-form" action="/delete-product" method="post">
                                <input type="hidden" name="productid" value="<?= $item['PRODUCTID'] ?>">
                                <input type="hidden" name="return" value="<?= $_SERVER['REQUEST_URI'] ?>">
                                <button type="submit" class="delete-btn">Remove</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>