<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.html"); // Redirect if not a logged-in patient
    exit;
}


// Retrieve form data
$patient_id = $_SESSION['user_id']; // Patient's ID from the session
$doctor_id = $_POST['doctor_id'];
$appointment_date = $_POST['appointment_date'];
$notes = $_POST['notes'] ?? null; // Notes are optional

// Insert the appointment into the database
try {
    $stmt = $pdo->prepare("INSERT INTO appointment (patient_id, doctor_id, appointment_date, notes) VALUES (?, ?, ?, ?)");
    $stmt->execute([$patient_id, $doctor_id, $appointment_date, $notes]);

    echo "Appointment scheduled successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>



