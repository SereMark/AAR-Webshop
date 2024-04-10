<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link rel="stylesheet" href="assets/css/shared.css">
    <link rel="stylesheet" href="assets/css/error.css">
</head>
<body>
<div class="container">
    <div class="content-error">
        <h1>Oops!</h1>
        <h2><?php echo isset($error_message) ? $error_message : "Something went wrong."; ?></h2>
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