<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/assets/css/shared.css">
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
    <main class="dashboard">
        <section class="dashboard-section">
            <h2>Users</h2>
            <div class="table-wrapper">
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['USERID'] ?? '') ?></td>
                            <td><?= htmlspecialchars($user['NAME'] ?? '') ?></td>
                            <td><?= htmlspecialchars($user['EMAIL'] ?? '') ?></td>
                            <td>
                                <?php if ($user['USERID'] != $_SESSION['userid']): ?>
                                    <div class="actions-group">
                                        <form action="/delete-profile" method="post">
                                            <input type="hidden" name="userid" value="<?= $user['USERID'] ?>">
                                            <button type="submit" class="btn-delete">Delete</button>
                                        </form>
                                        <form action="/set-admin-status" method="post">
                                            <input type="hidden" name="userid" value="<?= $user['USERID'] ?>">
                                            <button type="submit" class="btn-admin"><?= $user['ISADMIN'] == 'Y' ? 'Revoke Admin' : 'Make Admin' ?></button>
                                        </form>
                                    </div>
                                <?php else: ?>
                                    <div class="actions-group">
                                        <button disabled class="btn-delete" title="You cannot delete your own account">Delete</button>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
        <section class="dashboard-section">
            <h2>Orders</h2>
            <div class="table-wrapper">
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>User ID</th>
                            <th>Payment Method</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= htmlspecialchars($order['ORDERID'] ?? '') ?></td>
                            <td><?= htmlspecialchars($order['USERID'] ?? '') ?></td>
                            <td><?= htmlspecialchars($order['PAYMENTMETHOD'] ?? '') ?></td>
                            <td>$<?= htmlspecialchars($order['TOTALAMOUNT'] ?? '') ?></td>
                            <td>
                                <form action="/delete-order" method="post">
                                    <input type="hidden" name="orderid" value="<?= $order['ORDERID'] ?>">
                                    <button type="submit" class="btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
        <section class="dashboard-section">
            <h2>Reviews</h2>
            <div class="table-wrapper">
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Review ID</th>
                            <th>User ID</th>
                            <th>Product ID</th>
                            <th>Text</th>
                            <th>Rating</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reviews as $review): ?>
                        <tr>
                            <td><?= htmlspecialchars($review['REVIEWID'] ?? '') ?></td>
                            <td><?= htmlspecialchars($review['USERID'] ?? '') ?></td>
                            <td><?= htmlspecialchars($review['PRODUCTID'] ?? '') ?></td>
                            <td><?= htmlspecialchars($review['TEXT'] ?? '') ?></td>
                            <td><?= htmlspecialchars($review['RATING'] ?? '') ?></td>
                            <td>
                                <form action="/delete-review" method="post">
                                    <input type="hidden" name="reviewid" value="<?= $review['REVIEWID'] ?>">
                                    <input type="hidden" name="adminDashboard" value="true">
                                    <button type="submit" class="btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
        <section class="dashboard-section">
            <h2>Products</h2>
            <div class="table-wrapper">
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= htmlspecialchars($product['PRODUCTID'] ?? '') ?></td>
                            <td><?= htmlspecialchars($product['NAME'] ?? '') ?></td>
                            <td><?= htmlspecialchars($product['DESCRIPTION'] ?? '') ?></td>
                            <td>$<?= htmlspecialchars($product['PRICE'] ?? '') ?></td>
                            <td>
                                <form action="/delete-product" method="post">
                                    <input type="hidden" name="productid" value="<?= $product['PRODUCTID'] ?>">
                                    <button type="submit" class="btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
        <section class="dashboard-section">
            <h2>Categories</h2>
            <form action="/add-category" method="post" class="add-category-form">
                <input type="text" name="categoryName" placeholder="Enter category name" required>
                <button type="submit" class="btn">Add Category</button>
            </form>
            <div class="table-wrapper">
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Category ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?= htmlspecialchars($category['CATEGORYID'] ?? '') ?></td>
                            <td><?= htmlspecialchars($category['NAME'] ?? '') ?></td>
                            <td>
                                <form action="/delete-category" method="post">
                                    <input type="hidden" name="categoryid" value="<?= $category['CATEGORYID'] ?>">
                                    <button type="submit" class="btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>