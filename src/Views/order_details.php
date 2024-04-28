<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Overview</title>
    <link rel="stylesheet" href="/assets/css/order-details.css">
</head>
<body>
<?php
$usersModel = new UsersModel();
$userId = $_SESSION['userid'] ?? null;
$zipcode = $_POST['zipcode'] ?? 'N/A';
$city = $_POST['city'] ?? 'N/A';
$address = $_POST['address'] ?? 'N/A';
$payment_type = $_POST['payment_type'] ?? 'N/A';
$payment_type_value = "";
$has_payment_value = $payment_type == "pod" || $payment_type == "card";
if ($has_payment_value) {
    $payment_type_value = $payment_type == "pod" ? "Pay on delivery" : "Credit Card";
}
$user = $usersModel->getUserDetailsById($userId);

$totalPrice = 0;
foreach ($cartItems as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}

?>
<main class="main-content">
    <div class="order-container">
        <div class="overview">
            <h2>Overview</h2>
            <ul class="list-items">
                <?php
                foreach ($cartItems as $item):
                    ?>
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
                            <input style="display: none" type="hidden" name="cartitemid"
                                   value="<?= $item['cartitemid'] ?>">
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="total-amount">
                <p class="total-label">Total:</p>
                <span class="total-price">$<?= number_format($totalPrice, 2) ?></span>
            </div>


            <div class="details">
                <div>
                    <label for="zipcode">Zip Code</label>
                    <div>
                        <?= htmlspecialchars($zipcode) ?>
                    </div>

                    <label for="city">City</label>
                    <div>
                        <?= htmlspecialchars($city) ?>
                    </div>

                    <label for="address">Address</label>
                    <div>
                        <?= htmlspecialchars($address) ?>
                    </div>
                </div>
                <div>
                    <label for="payment-type">Payment Type</label>
                    <div>
                        <?= htmlspecialchars($payment_type_value) ?>
                    </div>

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