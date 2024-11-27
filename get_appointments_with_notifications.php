<?php
include 'db.php'; // Include the database connection file
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
           u_patient.first_name AS patient_first_name, u_patient.last_name AS patient_last_name
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
           u_patient.first_name AS patient_first_name, u_patient.last_name AS patient_last_name
    FROM appointments a
    JOIN users u_doctor ON a.doctor_id = u_doctor.user_id
    JOIN users u_patient ON a.patient_id = u_patient.user_id
    WHERE (a.patient_id = :user_id OR a.doctor_id = :user_id)
    AND a.appointment_date <= NOW()
    ORDER BY a.appointment_date DESC
");
$stmtPast->execute([':user_id' => $current_user_id]);
$pastAppointments = $stmtPast->fetchAll();

// Fetch notifications related to appointments
$stmtNotifications = $pdo->prepare("
    SELECT n.notification_id, n.content, n.created_at, n.read_status,
           a.appointment_id
    FROM notifications n
    JOIN appointments a ON n.message_id = a.appointment_id
    WHERE n.user_id = :user_id AND n.type = 'appointment'
    ORDER BY n.created_at DESC
");
$stmtNotifications->execute([':user_id' => $current_user_id]);
$notifications = $stmtNotifications->fetchAll();

// Return all data as JSON for frontend
echo json_encode([
    'upcomingAppointments' => $upcomingAppointments,
    'pastAppointments' => $pastAppointments,
    'notifications' => $notifications
]);
?>
