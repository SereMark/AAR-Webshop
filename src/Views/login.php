<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/assets/css/auth.css">
</head>
<body>
<div class="auth-form">
    <form method="post" action="/api/login">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>