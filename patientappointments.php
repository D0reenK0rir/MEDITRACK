<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Appointment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            padding: 20px;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 60px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, select, textarea, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #4a90e2;
            color: #fff;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #357ab8;
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
    
    </style>
</head>
<body>
<nav class="navbar">
        <div class="logo">Meditrack Patient Dashboard</div>
        <ul class="nav-links">
            <li><a href="patientdashboard.php">Home</a></li>
            <li><a href="patientappointment_checker.html">My Appointments</a></li>
            <li><a href="patientmedications.html">Medications</a></li>
            <li><a href="medicationreminder_checker.html">My Medications</a></li>
            <li><a href="patientmessages.php">Send Messages</a></li>
            <li><a href="patientmessages-checker.html">Messages</a></li>
            <li><a href="patienthealthtips.html">Health Tips</a></li>
        </ul>
        
    </nav>
    <div class="container">
        <h2>Schedule an Appointment</h2>
        <form action="schedule_appointment.php" method="POST">
            <!-- Dropdown to select the recipient -->
            <label for="receiver_id">Select User:</label>
            <select id="receiver_id" name="receiver_id" required>
                <?php
                include 'db.php';
                session_start();

                // Fetch all users except the logged-in user
                $current_user_id = $_SESSION['user_id'];
                $stmt = $pdo->prepare("SELECT user_id, CONCAT(first_name, ' ', last_name) AS name, role FROM users WHERE user_id != ?");
                $stmt->execute([$current_user_id]);
                $users = $stmt->fetchAll();

                foreach ($users as $user) {
                    echo "<option value='{$user['user_id']}'>{$user['name']} ({$user['role']})</option>";
                }
                ?>
            </select>

            <!-- Input for date and time -->
            <label for="appointment_date">Appointment Date and Time:</label>
            <input type="datetime-local" id="appointment_date" name="appointment_date" required>

            <!-- Textarea for notes -->
            <label for="notes">Notes:</label>
            <textarea id="notes" name="notes" placeholder="Enter any additional details..."></textarea>

            <!-- Submit button -->
            <button type="submit">Schedule Appointment</button>
        </form>
    </div>
    <footer>
        <p>&copy; 2024 Meditrack. All Rights Reserved.</p>
    </footer>
</body>
</html>
