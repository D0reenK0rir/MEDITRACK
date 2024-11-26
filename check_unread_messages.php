<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not authenticated']);
    exit;
}

$current_user_id = $_SESSION['user_id'];

// Fetch count of unread messages for the logged-in user
$stmt = $pdo->prepare("SELECT COUNT(*) AS unread_count FROM messages WHERE receiver_id = ? AND read_status = 0");
$stmt->execute([$current_user_id]);
$unreadCount = $stmt->fetchColumn();

echo json_encode(['status' => 'success', 'unread_count' => $unreadCount]);
?>
