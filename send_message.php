<?php
include 'db.php'; // Include the database connection file
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

// Retrieve form data
$sender_id = $_SESSION['user_id'];
$receiver_id = $_POST['receiver_id'];
$message_content = $_POST['message_content'];

// Insert the message into the database
try {
    // Insert message
    $stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, message_content, read_status) VALUES (?, ?, ?, 0)");
    $stmt->execute([$sender_id, $receiver_id, $message_content]);

    // Get the inserted message ID
    $message_id = $pdo->lastInsertId();

    // Insert a notification for the recipient
    $notification_content = "You have a new message from {$sender_id}"; // Adjust as needed
    $stmtNotification = $pdo->prepare("INSERT INTO notifications (user_id, message_id, type, content) VALUES (?, ?, 'message', ?)");
    $stmtNotification->execute([$receiver_id, $message_id, $notification_content]);

    echo "Message and notification sent successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

