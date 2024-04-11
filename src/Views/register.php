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
            <form method="post" action="/api/register">
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="tel" name="phone" placeholder="Phone Number" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Register</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>