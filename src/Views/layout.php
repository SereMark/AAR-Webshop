<?php
if (DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Webshop</title>
    <link rel="stylesheet" href="assets/css/shared.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <script src="assets/js/modal.js"></script>
</head>
<body>

<?php include __DIR__ . '/navbar.php'; ?>

<div class="main">
    <?php if (isset($content)) include $content; ?>
</div>

<?php include __DIR__ . '/footer.php'; ?>

</body>
</html>