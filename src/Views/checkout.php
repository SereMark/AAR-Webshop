<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/assets/css/checkout.css">
    <script src="/assets/js/checkout.js"></script>
</head>
<body>
    <main class="main-content">
        <section class="list">
            <form action="/order-details" method="post" onSubmit="return validateForm()">
                <h2>Shipping Information</h2>
                <div class="shipping-details">
                    <div class="form-field">
                        <label for="zipcode">Zip Code:</label>
                        <input type="text" id="zipcode" name="zipcode" required>
                    </div>
                    <div class="form-field">
                        <label for="city">City:</label>
                        <input type="text" id="city" name="city" required>
                    </div>
                    <div class="form-field">
                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" required>
                    </div>
                </div>

                <?php 
                    $finalPrice = 0;
                
                    foreach ($cartItems as $item) {
                        $finalPrice += $item['price'];}
                ?>
                 <?php if ($balance <= $finalPrice): ?>
                <h2>Payment Information</h2>
                <div class="payment-method-block">
                    <div class="radio-main">
                        <input class="track-item" id="payment_type_card" type="radio" name="payment_type" value="card">
                        <label class="track-label" for="payment_type_card">Credit Card</label>
                        <input class="track-item" id="payment_type_pod" type="radio" name="payment_type" value="pod"
                           checked>
                        <label class="track-label" for="payment_type_pod">Pay on Delivery</label>
                        <div class="track">
                            <div class="track__inner">
                                <div class="track__ball-hole">
                                    <div class="track__ball"></div>
                                </div>
                                <span class="track__separator"></span>
                                <div class="track__ball-hole">
                                    <div class="track__ball"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-details">
                        <div class="row">
                            <div class="form-field">
                                <label for="cardnumber">Card Number:</label>
                                <input type="text" id="cardnumber" name="cardnumber" required>
                            </div>
                            <div class="form-field">
                                <label for="expirydate">Expiry Date:</label>
                                <input type="text" id="expirydate" name="expirydate" value="01/24" tabindex="-1">
                            <label for="month">MM</label><input type="number" id="month" value="1" min="1" max="12" onchange="validateFormMonth()">
                            <label for="year">YY</label><input type="number" id="year" value="24" min="24" max="99" onchange="validateFormYear()">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-field">
                                <label for="cardname">Cardholder Name:</label>
                                <input type="text" id="cardname" name="cardname" required>
                            </div>
                            <div class="form-field">
                                <label for="cvc">CVC:</label>
                                <input type="text" id="cvc" name="cvc" required>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="form-actions button-group">
                    <button type="button" class="cancel-btn" onclick="window.history.back();">Back to Cart</button>
                    <button type="submit" class="confirm-btn">Proceed to Payment</button>
                </div>
            </form>
        </section>
    </main>
</body>

</html>