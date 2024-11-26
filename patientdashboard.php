<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.html"); // Redirect to login if not authenticated as patient
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
    <meta http-equiv="X-UA-Compatible="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <style>body {
        font-family: 'Arial', sans-serif;
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
        position: relative;
        bottom: 0;
        width: 100%;
    }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">Meditrack Patient Dashboard</div>
        <p>Hello, <?php echo htmlspecialchars($firstName . ' ' . $lastName); ?> !</p>
        <ul class="nav-links">
            <li><a href="patientappointments.html">My Appointments</a></li>
            <li><a href="patientmedications.html">Medications</a></li>
            <li><a href="patientmessages.php">Messages</a></li>
            <li><a href="messages_checker.html">Messages</a></li>
            <li><a href="patienthealthtips.html">Health Tips</a></li>
        </ul>
        
    </nav>

    <section id="dashboard">
        <div class="dashboard-summary">
            <h2>Welcome to Your Dashboard</h2>
            <div class="summary-cards">
                <div class="card">
                    <h3>Next Appointment</h3>
                    <p>Dr. Smith – October 10, 2024, at 10:00 AM</p>
                </div>
                <div class="card">
                    <h3>Today's Medications</h3>
                    <p>2 Reminders</p>
                </div>
                <div class="card">
                    <h3>New Messages</h3>
                    <p>1 Unread</p>
                </div>
            </div>
        </div>
    </section>

    <section id="appointments" class="section">
        <h2>Upcoming Appointments</h2>
        <div class="appointment-list">
            <div class="appointment-item">
                <p><strong>Check-up with Dr. Lee</strong> – October 15, 2024, at 2:00 PM</p>
                <button class="action-button">View Details</button>
            </div>
            <!-- More appointments as needed -->
        </div>
    </section>

    <section id="medications" class="section">
        <h2>Medication Reminders</h2>
        <div class="medication-list">
            <div class="medication-item">
                <p><strong>Medicine:</strong> Amoxicillin <br><strong>Time:</strong> 8:00 AM</p>
            </div>
            <div class="medication-item">
                <p><strong>Medicine:</strong> Ibuprofen <br><strong>Time:</strong> 2:00 PM</p>
            </div>
            <!-- More medications as needed -->
        </div>
    </section>

    <section id="messages" class="section">
        <h2>Messages</h2>
        <div class="message-list">
            <div class="message-item">
                <p><strong>Clinic:</strong> Your test results are ready. Please check your email for details.</p>
                <button class="action-button">View</button>
            </div>
            <!-- More messages as needed -->
        </div>
    </section>

    <section id="health-tips" class="section">
        <h2>Health Tips</h2>
        <p>Stay hydrated and maintain a balanced diet to support your immune system.</p>
        <!-- Additional health tips can be added here -->
    </section>

    <footer>
        <p>&copy; 2024 Meditrack. All Rights Reserved.</p>
    </footer>

    <script src="patient.js"></script>
</body>
</html>





