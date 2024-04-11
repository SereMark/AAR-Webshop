<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/assets/css/notfound.css">
</head>
<body class="notfound">
    <h1 class="notfound-404">404</h1>
    <h2 class="notfound-message">Oops! Page not found.</h2>
    <?php if (DEBUG): ?>
        <div class="debug-info">
            <h3 class="debug-title">Debugging Information:</h3>
            <pre><?php debug_print_backtrace(); ?></pre>
        </div>
    <?php endif; ?>
</body>
</html>