<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/assets/css/list.css">
</head>
<body>
    <main class="main-content">
        <section class="list">
            <?php if (empty($productItems)): ?>
                <!-- <p class="empty-list">Your product list is empty.</p> -->
                <p class="empty-list">Elcsesztük a tervezést, nincs a termékekhez UserID csatolva.</p>
            <?php else: ?>
                <ul class="list-items">
                    <?php foreach ($productItems as $item): ?>
                        <li class="list-item">
                            <div class="item-details">
                                <h2 class="item-name"><?= htmlspecialchars($item['productname']) ?></h2>
                                <p class="item-info">Price: <?= htmlspecialchars($item['price']) ?>$</p>
                            </div>
                            <form class="delete-form" action="/product/delete" method="post">
                                <input type="hidden" name="productitemid" value="<?= $item['productitemid'] ?>">
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