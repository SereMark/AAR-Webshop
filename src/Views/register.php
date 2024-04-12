<!DOCTYPE html>
<html>
<head>
    <!-- Link to the authentication CSS file -->
    <link rel="stylesheet" href="/assets/css/auth.css">
</head>
<body>
<div id="registerModal" class="modal">
    <!-- Modal content container -->
    <div class="modal-content">
        <!-- Close button for the modal -->
        <span class="close">&times;</span>
        <!-- Start of the registration form -->
        <div class="auth-form">
            <!-- Form for registration with method POST -->
            <form method="post" action="/api/register" class="ajax-form">
                <!-- Input fields for username, email, phone number, password, and password confirmation -->
                <input type="text" name="name" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="tel" name="phone" placeholder="Phone Number" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <!-- Container for error messages -->
                <div class="error" style="display: none;"></div>
                <!-- Submit button for the form -->
                <button type="submit">Register</button>
            </form>
        </div>
        <!-- End of the registration form -->
    </div>
</div>
</body>
</html>