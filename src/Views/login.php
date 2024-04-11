<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/assets/css/auth.css">
</head>
<body>
<div id="loginModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
        <div class="auth-form">
        <form method="post" action="/api/login">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        </div>
  </div>
</div>
</body>
</html>