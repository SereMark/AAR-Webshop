<!DOCTYPE html>
<html>
<head>
    <!-- Link to the authentication CSS file -->
    <link rel="stylesheet" href="/assets/css/auth.css">
</head>
<body>
<div id="loginModal" class="modal">
  <!-- Modal content container -->
  <div class="modal-content">
    <!-- Close button for the modal -->
    <span class="close">&times;</span>
    <div class="auth-form">
        <!-- Form for login with method POST -->
        <form method="post" action="/api/login" class="ajax-form">
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