<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/assets/css/shared.css">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <script>
        let jsonData = <?php echo $jsonData; ?>;
    </script>
    <script src="/assets/js/admin.js"></script>
</head>
<body>
<main class="dashboard">
    <section class="dashboard-section">
        <button class="collapsible" data-target="users">Users <span class="arrow">&#9660;</span>
        </button>
        <div class="table-wrapper collapsible-content" id="users">
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
                                        <button type="submit"
                                                class="btn-admin"><?= $user['ISADMIN'] == 'Y' ? 'Revoke Admin' : 'Make Admin' ?></button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <div class="actions-group">
                                    <button disabled class="btn-delete" title="You cannot delete your own account">
                                        Delete
                                    </button>
                                    <button disabled class="btn-admin"
                                            title="You cannot change your own admin status"><?= $user['ISADMIN'] == 'Y' ? 'Revoke Admin' : 'Make Admin' ?></button>
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
        <button class="collapsible" data-target="orders">Orders <span class="arrow">&#9660;</span>
        </button>
        <div class="table-wrapper collapsible-content" id="orders">
            <table class="styled-table">
                <thead>
                <tr>
                    <th>User ID</th>
                    <th>Payment Method</th>
                    <th>Total</th>
                    <th>Zipcode</th>
                    <th>City</th>
                    <th>Address</th>
                    <th>Order Date</th>
                    <th>Payment Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['USERID'] ?? '') ?></td>
                        <td><?= htmlspecialchars($order['PAYMENTMETHOD'] ?? '') ?></td>
                        <td>$<?= htmlspecialchars($order['TOTALAMOUNT'] ?? '') ?></td>
                        <td><?= htmlspecialchars($order['ZIPCODE'] ?? '') ?></td>
                        <td><?= htmlspecialchars($order['CITY'] ?? '') ?></td>
                        <td><?= htmlspecialchars($order['ADDRESS'] ?? '') ?></td>
                        <td><?= htmlspecialchars($order['ORDERDATE'] ?? '') ?></td>
                        <td>
                            <?= $order['PAYED'] == 'Y' ? '<span style="color:green;">Payed</span>' : ($order['WARNING_OVERDUE'] == 'Y' ? '<span style="color:red;">Overdue</span>' : 'On time') ?>
                        </td>
                        <td>
                            <form action="/mark-as-paid" method="post">
                                <input type="hidden" name="orderid" value="<?= $order['ORDERID'] ?>">
                                <?php if ($order['PAYED'] != 'Y'): ?>
                                    <button type="submit" class="btn btn-success">Mark as Paid</button>
                                <?php endif; ?>
                            </form>
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
        <button class="collapsible" data-target="delivered">To Be Delivered Orders <span class="arrow">&#9660;</span>
        </button>
        <div class="table-wrapper collapsible-content" id="delivered">
            <table class="styled-table">
                <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Order Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $currentDate = null;
                foreach ($toDeliverOrders as $order):
                    if ($currentDate !== $order['ORDERDATE']):
                        if ($currentDate !== null):
                            echo '<tr class="date-group-separator"><td colspan="6"></td></tr>';
                        endif;
                        echo '<tr class="group-heading"><td colspan="6">Orders for ' . htmlspecialchars($order['ORDERDATE']) . '</td></tr>';
                        $currentDate = $order['ORDERDATE'];
                    endif;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($order['ORDERID'] ?? '') ?></td>
                        <td><?= htmlspecialchars($order['USERID'] ?? '') ?></td>
                        <td><?= htmlspecialchars($order['ORDERDATE'] ?? '') ?></td>
                        <td>$<?= htmlspecialchars($order['TOTALAMOUNT'] ?? '') ?></td>
                        <td><?= $order['PAYED'] == 'Y' ? '<span style="color:green;">Paid</span>' : '<span style="color:red;">Unpaid</span>' ?></td>
                        <td>
                            <form action="/mark-as-delivered" method="post">
                                <input type="hidden" name="orderid" value="<?= $order['ORDERID'] ?>">
                                <?php if (empty($order['DeliveryDate'])): ?>
                                    <button type="submit" class="btn btn-success">Mark as Delivered</button>
                                <?php endif; ?>
                            </form>
                        </td>
                    </tr>
                <?php
                endforeach;
                if ($currentDate !== null):
                    echo '<tr class="date-group-separator"><td colspan="6"></td></tr>';
                endif;
                ?>
                </tbody>
            </table>
        </div>
    </section>
    <section class="dashboard-section">
        <button class="collapsible" data-target="reviews">Reviews <span class="arrow">&#9660;</span>
        </button>
        <div class="table-wrapper collapsible-content" id="reviews">
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
        <button class="collapsible" data-target="products">Products <span class="arrow">&#9660;</span>
        </button>
        <div class="table-wrapper collapsible-content" id="products">
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
                                <input type="hidden" name="return" value="<?= $_SERVER['REQUEST_URI'] ?>">
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
        <button class="collapsible" data-target="categories">Categories <span class="arrow">&#9660;</span>
        </button>
        <form action="/add-category" method="post" class="add-form">
            <input type="text" name="categoryName" placeholder="Enter category name" required>
            <button type="submit" class="btn">Add Category</button>
        </form>
        <div class="table-wrapper collapsible-content" id="categories">
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
    <section class="dashboard-section">
        <button class="collapsible" data-target="coupons">Coupons <span class="arrow">&#9660;</span>
        </button>
        <form action="/add-coupon" method="post" class="add-form">
            <input type="text" name="couponCode" placeholder="Enter coupon code" required>
            <input type="text" name="discount" placeholder="Enter discount amount" required>
            <button type="submit" class="btn">Add Coupon</button>
        </form>
        <div class="table-wrapper collapsible-content" id="coupons">
            <table class="styled-table">
                <thead>
                <tr>
                    <th>Coupon ID</th>
                    <th>Code</th>
                    <th>Discount</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($coupons as $coupon): ?>
                    <tr>
                        <td><?= htmlspecialchars($coupon['COUPONID'] ?? '') ?></td>
                        <td><?= htmlspecialchars($coupon['CODE'] ?? '') ?></td>
                        <td><?= htmlspecialchars($coupon['DISCOUNT'] ?? '') ?>%</td>
                        <td>
                            <form action="/delete-coupon" method="post">
                                <input type="hidden" name="couponid" value="<?= $coupon['COUPONID'] ?>">
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
        <button class="collapsible" data-target="statistics">Statistics <span class="arrow">&#9660;</span>
        </button>
        <div class="table-wrapper collapsible-content" id="statistics">
            <canvas id="revenueChart"></canvas>
        </div>
    </section>
</main>
</body>
</html>