<?php
            include 'db.php'; // Database connection

            // Fetch all users except the logged-in user
            session_start();
            $current_user_id = $_SESSION['user_id'];
            $stmt = $pdo->prepare("SELECT user_id, CONCAT(first_name, ' ', last_name) AS name FROM users WHERE user_id != ?");
            $stmt->execute([$current_user_id]);
            $users = $stmt->fetchAll();

            foreach ($users as $user) {
                echo "<option value='{$user['user_id']}'>{$user['name']}</option>";
            }
            ?>
            <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Message</title>
</head>
<body>
    <h2>Send a Message</h2>
    <form action="send_message.php" method="post">
        <label for="receiver_id">Select Recipient:</label>
        <select id="receiver_id" name="receiver_id" required>
        </select>

<label for="message_content">Message:</label>
<textarea id="message_content" name="message_content" required></textarea>

<button type="submit">Send Message</button>
</form>
</body>
</html>