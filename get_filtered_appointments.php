<?php
include 'db.php'; // Include the database connection file
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$current_user_id = $_SESSION['user_id'];

// Check the role of the logged-in user
$stmtRole = $pdo->prepare("SELECT role FROM users WHERE user_id = ?");
$stmtRole->execute([$current_user_id]);
$userRole = $stmtRole->fetchColumn();

// Fetch appointments based on the user's role
if ($userRole === 'doctor') {
    // If the user is a doctor, fetch appointments where they are the doctor
    $stmt = $pdo->prepare("
        SELECT a.appointment_id, a.appointment_date, a.status, a.notes,
               u_patient.first_name AS patient_first_name, u_patient.last_name AS patient_last_name
        FROM appointment a
        JOIN users u_patient ON a.patient_id = u_patient.user_id
        WHERE a.doctor_id = :user_id AND a.status = 'scheduled'
        ORDER BY a.appointment_date ASC
    ");
} elseif ($userRole === 'patient') {
    // If the user is a patient, fetch appointments where they are the patient
    $stmt = $pdo->prepare("
        SELECT a.appointment_id, a.appointment_date, a.status, a.notes,
               u_doctor.first_name AS doctor_first_name, u_doctor.last_name AS doctor_last_name
        FROM appointment a
        JOIN users u_doctor ON a.doctor_id = u_doctor.user_id
        WHERE a.patient_id = :user_id AND a.status = 'scheduled'
        ORDER BY a.appointment_date ASC
    ");
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid user role']);
    exit;
}

// Execute the query with the logged-in user's ID
$stmt->execute([':user_id' => $current_user_id]);
$appointments = $stmt->fetchAll();

// Return appointments as JSON
echo json_encode($appointments);
?>
