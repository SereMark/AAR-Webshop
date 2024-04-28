<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Set the character encoding for the document -->
    <meta charset="UTF-8">
    <!-- Link to the notfound CSS file -->
    <link rel="stylesheet" href="/assets/css/notfound.css">
</head>
<body class="notfound">
    <!-- Display a 404 error message -->
    <h1 class="notfound-404">404</h1>
    <!-- Display a message indicating that the page was not found -->
    <h2 class="notfound-message">Oops! Page not found.</h2>
    <!-- If the DEBUG constant is true, display debugging information -->
    <?php if (DEBUG): ?>
        <div class="debug-info">
            <!-- Title for the debugging information -->
            <h3 class="debug-title">Debugging Information:</h3>
            <!-- Display the backtrace -->
            <pre><?php debug_print_backtrace(); ?></pre>
        </div>
    <?php endif; ?>
</body>
</html>