<?php
include 'db.php'; // Include the database connection
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$current_user_id = $_SESSION['user_id'];
$type = $_GET['type']; // 'received' or 'sent'

// SQL query to fetch messages based on type
if ($type == 'received') {
    // Fetch received messages
    $stmt = $pdo->prepare("
        SELECT m.message_id, m.sender_id, m.receiver_id, m.message_content, m.sent_at, m.read_status,
               u_sender.first_name AS sender_first_name, u_sender.last_name AS sender_last_name
        FROM messages m
        JOIN users u_sender ON m.sender_id = u_sender.user_id
        WHERE m.receiver_id = ? AND m.read_status = 0
        ORDER BY m.sent_at DESC
    ");
    $stmt->execute([$current_user_id]);
    $messages = $stmt->fetchAll();
} else if ($type == 'sent') {
    // Fetch sent messages
    $stmt = $pdo->prepare("
        SELECT m.message_id, m.sender_id, m.receiver_id, m.message_content, m.sent_at,
               u_receiver.first_name AS receiver_first_name, u_receiver.last_name AS receiver_last_name
        FROM messages m
        JOIN users u_receiver ON m.receiver_id = u_receiver.user_id
        WHERE m.sender_id = ?
        ORDER BY m.sent_at DESC
    ");
    $stmt->execute([$current_user_id]);
    $messages = $stmt->fetchAll();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid message type']);
    exit;
}

echo json_encode($messages); // Return messages as JSON for frontend
?>
