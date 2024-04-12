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
    <link rel="stylesheet" href="/assets/css/shared.css">
    <link rel="stylesheet" href="/assets/css/navbar.css">
    <link rel="stylesheet" href="/assets/css/modal.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon.ico" />
    <title><?php echo isset($pageTitle) ? $pageTitle : "Webshop"; ?></title>
</head>
<body>

<!-- Navbar -->
<?php include __DIR__ . '/navbar.php'; ?>

<!-- Main Content with infoModal and connection check -->
<div class="main">
    <?php include __DIR__ . '/infoModal.php'; ?>
    <?php include __DIR__ . '/connection.php'; ?>
    <?php if (isset($content)) include $content; ?>
</div>

<!-- Footer -->
<?php include __DIR__ . '/footer.php'; ?>

<!-- Scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="/assets/js/ajax-handler.js?v=1.0"></script>

<script> var showModalAfterSeconds = <?php echo SHOW_MODAL_AFTER_SECONDS; ?>; </script>
<script src="/assets/js/modal.js?v=1.0"></script>

</body>
</html>