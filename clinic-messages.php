<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Message</title>
    <style>
      /* Basic styling */
      body { 
        font-family: Arial, sans-serif; 
        background-color: #f4f7f6; 
        color: #333; 
        padding: 0;
        margin: 0;
    }
    .section {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .section h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        .message-form{
            margin-top: 20px;
            padding: 15px;
            background-color: #e7f1ff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
      .message-form label{
        font-size: 16px;
        margin-bottom: 5px;
        color: #555;
      }
      .message-form select { 
        display: block; 
        width: 100%; 
        margin-bottom: 10px; 
    }
      .message-form textarea { 
        height: 100px; 
        resize: vertical; 
        padding: 10px;
    }
      .action-button { 
        background-color: #4a90e2; 
        color: #fff; 
        padding: 5px 10px; 
        border: none; 
        border-radius: 5px; 
        width: 30%;
        cursor: pointer; 
    }
      .action-button:hover { 
        background-color: #357ab8; 
    }
      .navbar {
        background-color: #4a90e2;
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #fff;
    }
    
    .logo {
        font-size: 24px;
        font-weight: bold;
    }
    
    .nav-links {
        list-style: none;
        display: flex;
        gap: 20px;
    }
    
    .nav-links li {
        display: inline;
    }
    
    .nav-links a {
        color: #fff;
        text-decoration: none;
    }
    
    .user-profile {
        font-size: 16px;
    }
    
    .dashboard-summary {
        padding: 20px;
        background-color: #fff;
        margin: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    
    .summary-cards {
        display: flex;
        gap: 20px;
        justify-content: space-around;
    }
    
    .card {
        background-color: #e7f1ff;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
        width: 150px;
    }
    footer {
        text-align: center;
        padding: 1px;
        background-color: #4a90e2;
        color: #fff;
        position: relative;
        bottom: 0;
        width: 100%;
    }
    </style>
</head>
<body>
<nav class="navbar">
        <div class="logo">Doctor Dashboard</div>
        <ul class="nav-links">
            <li><a href="doctordashboard.php">Home</a></li>
            <li><a href="doctorappointments.php">Appointments</a></li>
            <li><a href="doctorappointment_checker.html">My Appointments</a></li>
            
            <li><a href="messages_checker.html">Messages</a></li>
        </ul>
        
    </nav>
    <section id="message-form" class="section">
    
        <h2>Send a Message</h2>
        <form id="message-form" class="message-form" action="send_message.php" method="post">
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
            <button type="submit" class="action-button">Send Message</button>
            
        </form>

</section>
    
    <footer>
        <p>&copy; 2024 Meditrack. All Rights Reserved.</p>
    </footer>
</body>
</html>
