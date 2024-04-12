<?php
// If the DEBUG constant is true, enable error reporting
if (DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Set the character encoding for the document -->
    <meta charset="UTF-8">
    <!-- Link to the shared, navbar, modal, and footer CSS files -->
    <link rel="stylesheet" href="/assets/css/shared.css">
    <link rel="stylesheet" href="/assets/css/navbar.css">
    <link rel="stylesheet" href="/assets/css/modal.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <!-- Set the favicon for the webpage -->
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon.ico" />
    <!-- Set the title of the webpage -->
    <title><?php echo isset($pageTitle) ? $pageTitle : "Webshop"; ?></title>
</head>
<body>

<!-- Include the navbar -->
<?php include __DIR__ . '/navbar.php'; ?>

<!-- Main content area -->
<div class="main">
    <!-- Include the infoModal and connection check -->
    <?php include __DIR__ . '/infoModal.php'; ?>
    <?php include __DIR__ . '/connection.php'; ?>
    <!-- Include the content if it is set -->
    <?php if (isset($content)) include $content; ?>
</div>

<!-- Include the footer -->
<?php include __DIR__ . '/footer.php'; ?>

<!-- Include the jQuery library and the ajax-handler script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="/assets/js/ajax-handler.js?v=1.0"></script>

<!-- Set the showModalAfterSeconds variable to the value of the SHOW_MODAL_AFTER_SECONDS constant -->
<script> var showModalAfterSeconds = <?php echo SHOW_MODAL_AFTER_SECONDS; ?>; </script>
<!-- Include the modal script -->
<script src="/assets/js/modal.js?v=1.0"></script>

</body>
</html>