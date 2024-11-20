<?php
include 'db.php'; // Include database connection file
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.html"); // Redirect if the user is not a logged-in patient
    exit;
}

// Retrieve form data
$patient_id = $_SESSION['user_id']; // Get the patient ID from the session
$name = $_POST['name'];
$dosage = $_POST['dosage'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$reminder_time = $_POST['reminder_time'];

// Insert the medication reminder into the database
try {
    $stmt = $pdo->prepare("INSERT INTO medications (patient_id, name, dosage, start_date, end_date, reminder_time) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$patient_id, $name, $dosage, $start_date, $end_date, $reminder_time]);

    echo "Medication reminder set successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

