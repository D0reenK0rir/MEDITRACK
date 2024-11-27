<?php
include 'db.php'; // Include the database connection
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$current_user_id = $_SESSION['user_id']; // Get the logged-in user's ID

// Fetch medication reminders for the logged-in patient
$stmt = $pdo->prepare("
    SELECT name, dosage, start_date, end_date, reminder_time
    FROM medications
    WHERE patient_id = ?  -- Filter reminders by the logged-in patient's ID
    ORDER BY reminder_time ASC
");

$stmt->execute([$current_user_id]);
$medications = $stmt->fetchAll();

// Check if medications are found and return the results
if (empty($medications)) {
    echo json_encode(['status' => 'error', 'message' => 'No medication reminders found for this patient.']);
    exit;
}

// Return the medication reminders as JSON for the frontend
echo json_encode($medications);
?>
