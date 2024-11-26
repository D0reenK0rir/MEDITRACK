<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$current_user_id = $_SESSION['user_id'];
$conversation_partner_id = $_GET['conversation_partner_id'];

// Fetch messages between the logged-in user and the conversation partner
$stmt = $pdo->prepare("
    SELECT m.message_id, m.sender_id, m.receiver_id, m.message_content, m.sent_at, m.read_status,
           u_sender.first_name AS sender_first_name, u_sender.last_name AS sender_last_name,
           u_receiver.first_name AS receiver_first_name, u_receiver.last_name AS receiver_last_name
    FROM messages m
    JOIN users u_sender ON m.sender_id = u_sender.user_id
    JOIN users u_receiver ON m.receiver_id = u_receiver.user_id
    WHERE (m.sender_id = :current_user_id AND m.receiver_id = :partner_id)
       OR (m.sender_id = :partner_id AND m.receiver_id = :current_user_id)
    ORDER BY m.sent_at ASC
");
$stmt->execute([
    ':current_user_id' => $current_user_id,
    ':partner_id' => $conversation_partner_id
]);
$messages = $stmt->fetchAll();

// Mark all unread messages as read
$updateStmt = $pdo->prepare("UPDATE messages SET read_status = 1 WHERE receiver_id = :current_user_id AND sender_id = :partner_id AND read_status = 0");
$updateStmt->execute([':current_user_id' => $current_user_id, ':partner_id' => $conversation_partner_id]);

echo json_encode($messages); // Output messages as JSON for JavaScript
?>
