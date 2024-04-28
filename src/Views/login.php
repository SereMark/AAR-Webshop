<!DOCTYPE html>
<html>
<head>
    <!-- Link to the form CSS file -->
    <link rel="stylesheet" href="/assets/css/form.css">
</head>
<body>
<div id="loginModal" class="modal">
  <!-- Modal content container -->
  <div class="modal-content">
    <!-- Close button for the modal -->
    <span class="close">&times;</span>
    <div class="form">
        <!-- Form for login with method POST -->
        <form method="post" action="/login" class="ajax-form">
            <h2>Login</h2>
            <!-- Input field for email -->
            <input type="email" name="email" placeholder="Email" required>
            <!-- Input field for password -->
            <input type="password" name="password" placeholder="Password" required>
            <!-- Container for error messages -->
            <div class="error" style="display: none;"></div>
            <!-- Submit button for the form -->
            <button type="submit">Login</button>
        </form>
    </div>
  </div>
</div>
</body>
</html>