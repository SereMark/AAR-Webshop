<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <link rel="stylesheet" href="assets/css/shared.css">
    <link rel="stylesheet" href="assets/css/404.css">
</head>
<body>
<div class="container">
    <div class="content-404">
        <h1>404</h1>
        <h2>Oops! Page not found.</h2>
        <p>Sorry, but the page you are looking for does not exist, has been removed, its name changed, or is temporarily unavailable. It might be that you typed the web address incorrectly, or the page has moved.</p>
    </div>
</div>
<?php if (DEBUG): ?>
    <div class="debug-info">
        <h3>Debugging Information:</h3>
        <pre><?php debug_print_backtrace(); ?></pre>
    </div>
<?php endif; ?>
</body>
</html>
