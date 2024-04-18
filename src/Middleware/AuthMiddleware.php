<?php
function checkIfAuthenticated() {
    if (isset($_SESSION['userid'])) {
        header('Location: /');
        exit();
    }
}