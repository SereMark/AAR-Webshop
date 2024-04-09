<?php
session_start();

function checkIfAuthenticated() {
    if (isset($_SESSION['user_id'])) {
        header('Location: /profile'); // Redirect to profile if already logged in
        exit();
    }
}