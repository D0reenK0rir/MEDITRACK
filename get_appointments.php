<?php
include 'db.php'; // Include database connection
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$current_user_id = $_SESSION['user_id'];

// Fetch upcoming appointments
$stmtUpcoming = $pdo->prepare("
    SELECT a.appointment_id, a.appointment_date, a.status, a.notes,
           u_doctor.first_name AS doctor_first_name, u_doctor.last_name AS doctor_last_name,
           u_patient.first_name AS patient_first_name, u_patient.last_name AS patient_last_name,
           CASE
               WHEN a.created_at = (SELECT MIN(created_at) FROM appointments WHERE appointment_id = a.appointment_id) THEN 'Doctor'
               ELSE 'Patient'
           END AS scheduled_by
    FROM appointments a
    JOIN users u_doctor ON a.doctor_id = u_doctor.user_id
    JOIN users u_patient ON a.patient_id = u_patient.user_id
    WHERE (a.patient_id = :user_id OR a.doctor_id = :user_id)
    AND a.appointment_date > NOW()
    ORDER BY a.appointment_date ASC
");
$stmtUpcoming->execute([':user_id' => $current_user_id]);
$upcomingAppointments = $stmtUpcoming->fetchAll();

// Fetch past appointments
$stmtPast = $pdo->prepare("
    SELECT a.appointment_id, a.appointment_date, a.status, a.notes,
           u_doctor.first_name AS doctor_first_name, u_doctor.last_name AS doctor_last_name,
           u_patient.first_name AS patient_first_name, u_patient.last_name AS patient_last_name,
           CASE
               WHEN a.created_at = (SELECT MIN(created_at) FROM appointments WHERE appointment_id = a.appointment_id) THEN 'Doctor'
               ELSE 'Patient'
           END AS scheduled_by
    FROM appointments a
    JOIN users u_doctor ON a.doctor_id = u_doctor.user_id
    JOIN users u_patient ON a.patient_id = u_patient.user_id
    WHERE (a.patient_id = :user_id OR a.doctor_id = :user_id)
    AND a.appointment_date <= NOW()
    ORDER BY a.appointment_date DESC
");
$stmtPast->execute([':user_id' => $current_user_id]);
$pastAppointments = $stmtPast->fetchAll();

// Return data as JSON
echo json_encode([
    'upcomingAppointments' => $upcomingAppointments,
    'pastAppointments' => $pastAppointments
]);
?>
