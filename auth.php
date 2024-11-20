<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html"); // Redirect if user is not logged in
    exit;
}

// Role-based redirection or restriction
if (basename($_SERVER['PHP_SELF']) === 'patient_dashboard.php' && $_SESSION['role'] !== 'patient') {
    header("Location: login.html");
    exit;
}

if (basename($_SERVER['PHP_SELF']) === 'doctor_dashboard.php' && $_SESSION['role'] !== 'doctor') {
    header("Location: login.html");
    exit;
}
?>
