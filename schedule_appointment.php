<?php
include 'db.php'; // Include the database connection
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

// Retrieve form data
$sender_id = $_SESSION['user_id']; // The logged-in user's ID
$receiver_id = $_POST['receiver_id']; // The selected user's ID
$appointment_date = $_POST['appointment_date'];
$notes = $_POST['notes'];

// Determine roles (doctor/patient)
$stmt = $pdo->prepare("SELECT role FROM users WHERE user_id = ?");
$stmt->execute([$sender_id]);
$sender_role = $stmt->fetchColumn();

$stmt->execute([$receiver_id]);
$receiver_role = $stmt->fetchColumn();

// Assign roles based on the logged-in user's role
if ($sender_role === 'doctor') {
    $doctor_id = $sender_id;
    $patient_id = $receiver_id;
} elseif ($sender_role === 'patient') {
    $doctor_id = $receiver_id;
    $patient_id = $sender_id;
} else {
    echo "Invalid roles.";
    exit;
}

// Insert the appointment into the database
try {
    $stmt = $pdo->prepare("
        INSERT INTO appointment (patient_id, doctor_id, appointment_date, status, notes) 
        VALUES (?, ?, ?, 'scheduled', ?)
    ");
    $stmt->execute([$patient_id, $doctor_id, $appointment_date, $notes]);

    echo "Appointment scheduled successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
