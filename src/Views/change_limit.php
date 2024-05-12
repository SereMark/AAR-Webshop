<!DOCTYPE html>
<html>
<head>
    <!-- Link to the form CSS file -->
    <link rel="stylesheet" href="/assets/css/form.css">
</head>
<body>
<!-- Product Add Modal -->
<div id="changeBalanceLimitModal" class="modal" style="display:none;">
  <!-- Modal content container -->
  <div class="modal-content">
    <!-- Close button for the modal -->
    <span class="close">&times;</span>
    <div class="form">  
        <form action="/change-balance" method="post">
            <label for="Card number">Card number:</label>
            <input type="text" id="card_number" name="card_number" required>
            <label for="CVC">CVC:</label>
            <input type="text" id="cvc" name="cvc" required>
            <label for="Expiry Date">Expiry Date:</label>
            <input type="text" id="expiry_date" name="expiry_date" required>
            <label for="Balance">Balance:</label>
            <input type="text" id="balance" name="balance" required>

            <button type="submit">Add card</button>
        </form>
    </div>
  </div>
</div>
</body>
</html>