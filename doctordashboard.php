<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header("Location: login.html"); // Redirect to login if not authenticated as doctor
    exit;
}

// Retrieve the user's name from the session
$firstName = $_SESSION['first_name'];
$lastName = $_SESSION['last_name'];
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Dashboard</title>
    <style>body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f9;
        color: #333;
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
    
    .section {
        padding: 20px;
        background-color: #fff;
        margin: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    
    .action-button {
        background-color: #4a90e2;
        color: #fff;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
    }
    
    .action-button:hover {
        background-color: #357ab8;
    }
    
    footer {
        text-align: center;
        padding: 1px;
        background-color: #4a90e2;
        color: #fff;
        position:relative;
        bottom: 0;
        width: 100%;
    }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">Meditrack Doctor Dashboard</div>
        <p>Hello Dr.  <?php echo htmlspecialchars($firstName . ' ' . $lastName); ?>!</p>
        <ul class="nav-links">
            <li><a href="clinic-appointments.html">Appointments</a></li>
            <li><a href="patient-records.html">Patient Records</a></li>
            <li><a href="clinic-messages.html">Messages</a></li>
            
        </ul>
        
    </nav>

    <section id="dashboard">
        <div class="dashboard-summary">
            <h2>Today's Overview</h2>
            <div class="summary-cards">
                <div class="card">
                    <h3>Appointments</h3>
                    <p>15 Scheduled</p>
                </div>
                <div class="card">
                    <h3>Checked-In Patients</h3>
                    <p>8 Checked-In</p>
                </div>
                <div class="card">
                    <h3>Messages</h3>
                    <p>3 New Messages</p>
                </div>
                <div class="card">
                    <h3>No-Show Rate</h3>
                    <p>5%</p>
                </div>
            </div>
        </div>
    </section>

    <section id="appointments" class="section">
        <h2>Appointments</h2>
        <div class="appointment-list">
            <div class="appointment-item">
                <p><strong>John Doe</strong> – 10:00 AM</p>
                <button class="action-button">View Details</button>
            </div>
            <div class="appointment-item">
                <p><strong>Jane Smith</strong> – 11:30 AM</p>
                <button class="action-button">View Details</button>
            </div>
            <!-- Add more appointment items as needed -->
        </div>
    </section>

    <section id="messages" class="section">
        <h2>Messages</h2>
        <div class="message-list">
            <div class="message-item">
                <p><strong>Patient:</strong> Can I reschedule my appointment?</p>
                <button class="action-button">Reply</button>
            </div>
            <!-- Add more message items as needed -->
        </div>
    </section>

    

    <footer>
        <p>&copy; 2024 Meditrack. All Rights Reserved.</p>
    </footer>

    <script src="clinic.js"></script>
</body>
</html>
