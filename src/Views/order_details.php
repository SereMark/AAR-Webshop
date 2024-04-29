<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/assets/css/order-details.css">
</head>
<body>
    <main class="main-content">
        <div class="order-container">
            <div class="overview">
                <h2>Overview</h2>
                <ul class="list-items">
                    <?php foreach ($cartItems as $item): ?>
                        <li class="list-item">
                            <div class="item-details item">
                                <div>
                                    <span>Name: </span>
                                    <p class="item-name"><?= htmlspecialchars($item['productname']) ?></p>
                                </div>
                                <div>
                                    <span>Quantity: </span>
                                    <p class="quantity-field"><?= $item['quantity'] ?></p>
                                </div>
                                <div>
                                    <span>Price: </span>
                                    <p class="item-price">$<?= number_format($item['price'] * $item['quantity'], 2) ?></p>
                                </div>
                                <input type="hidden" name="cartitemid" value="<?= $item['cartitemid'] ?>">
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="coupon-and-price">
                    <div class="coupon-block">
                        <form action="/order-details" method="post">
                            <label for="coupon">Coupon Code:</label>
                            <input type="text" id="coupon" name="coupon">
                            <input type="hidden" name="zipcode" value="<?= $zipcode ?>">
                            <input type="hidden" name="city" value="<?= $city ?>">
                            <input type="hidden" name="address" value="<?= $address ?>">
                            <input type="hidden" name="payment_type" value="<?= $payment_type ?>">
                            <input type="hidden" name="total_amount" value="<?= $totalPrice ?>">
                            <button type="submit" class="coupon-button">Add</button>
                        </form>
                    </div>
                    <div class="total-amount">
                        <p class="total-label">Total:</p>
                        <span class="total-price">$<?= number_format($totalPrice, 2) ?></span>
                    </div>
                </div>
                <div class="details">
                    <div>
                        <label for="zipcode">Zip Code</label>
                        <div><?= htmlspecialchars($zipcode) ?></div>
                        <label for="city">City</label>
                        <div><?= htmlspecialchars($city) ?></div>
                        <label for="address">Address</label>
                        <div><?= htmlspecialchars($address) ?></div>
                    </div>
                    <div>
                        <label for="payment-type">Payment Type</label>
                        <div><?= htmlspecialchars($payment_type_value) ?></div>
                        <label for="delivery-date">Delivery Date</label>
                        <div>
                            <?php
                            $dateFrom = strtotime("+3 days");
                            $dateTo = strtotime("+5 days");
                            echo date('Y.m.d', $dateFrom) . ' - ' . date('Y.m.d', $dateTo);
                            ?>
                        </div>
                        <label for="phone">Phone Number</label>
                        <div><?= htmlspecialchars($user["PHONENUMBER"]) ?></div>
                    </div>
                </div>
                <form id="order-form" method="post" action="/order-details/orderFeedback">
                    <input type="hidden" name="zipcode" value="<?= $zipcode ?>">
                    <input type="hidden" name="city" value="<?= $city ?>">
                    <input type="hidden" name="address" value="<?= $address ?>">
                    <input type="hidden" name="payment_type" value="<?= $payment_type_value ?>">
                    <input type="hidden" name="total_amount" value="<?= $totalPrice ?>">
                    <div class="form-actions button-group">
                        <button type="button" class="cancel-btn" onclick="window.history.back()">Back</button>
                        <button onclick="showModal('orderInserted')" type="submit" class="confirm-btn">Place order</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>