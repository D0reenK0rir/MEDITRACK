<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Message</title>
    <style>
      /* Basic styling */
      body { font-family: Arial, sans-serif; background-color: #f4f4f9; color: #333; }
      .container { width: 400px; margin: 20px auto; padding: 20px; background-color: #e7f1ff; border-radius: 8px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); }
      .message-form label, .message-form select, .message-form textarea, .message-form button { display: block; width: 100%; margin-bottom: 10px; }
      .message-form textarea { height: 100px; resize: vertical; }
      .message-form button { background-color: #4a90e2; color: #fff; padding: 10px; border: none; border-radius: 5px; cursor: pointer; }
      .message-form button:hover { background-color: #357ab8; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Send a Message</h2>
        <form id="message-form" action="send_message.php" method="post">
            <label for="receiver_id">Select Recipient:</label>
            <select id="receiver_id" name="receiver_id" required>
            <?php
    include 'db.php';
    session_start();
    
    // Get all users except the logged-in user, along with their roles
    $current_user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT user_id, CONCAT(first_name, ' ', last_name) AS name, role FROM users WHERE user_id != ?");
    $stmt->execute([$current_user_id]);
    $users = $stmt->fetchAll();

    foreach ($users as $user) {
        $displayText = "{$user['name']} (" . ucfirst($user['role']) . ")";
        echo "<option value='{$user['user_id']}'>{$displayText}</option>";
    }
    ?>
            </select>

            <label for="message_content">Message:</label>
            <textarea id="message_content" name="message_content" required></textarea>

            <button type="submit">Send Message</button>
        </form>
    </div>
</body>
</html>
