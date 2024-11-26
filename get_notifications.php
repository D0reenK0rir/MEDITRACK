<?php
include 'db.php'; // Include the database connection file
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$current_user_id = $_SESSION['user_id'];

// Fetch unread notifications for the logged-in user
$stmt = $pdo->prepare("
    SELECT n.notification_id, n.type, n.content, n.created_at, n.read_status, m.message_content
    FROM notifications n
    LEFT JOIN messages m ON n.message_id = m.message_id
    WHERE n.user_id = ? AND n.read_status = 0
    ORDER BY n.created_at DESC
");
$stmt->execute([$current_user_id]);
$notifications = $stmt->fetchAll();

// Mark all notifications as read once they are fetched
$updateStmt = $pdo->prepare("UPDATE notifications SET read_status = 1 WHERE user_id = ? AND read_status = 0");
$updateStmt->execute([$current_user_id]);

echo json_encode($notifications); // Return notifications as JSON for frontend
?>
