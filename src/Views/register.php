<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/assets/css/auth.css">
</head>
<body>
<div id="registerModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="auth-form">
            <form method="post" action="/api/register" class="ajax-form">
                <input type="text" name="name" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="tel" name="phone" placeholder="Phone Number" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <div class="error" style="display: none;"></div>
                <button type="submit">Register</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>