<?php
include 'db_connect.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user is a patient or doctor
    if (isset($_POST['role'])) {
        $role = $_POST['role'];
        if ($role === 'patient') {
            // Check patient credentials
            $stmt = $pdo->prepare("SELECT * FROM patients WHERE email = ?");
        } elseif ($role === 'doctor') {
            // Check doctor credentials
            $stmt = $pdo->prepare("SELECT * FROM doctors WHERE email = ?");
        } else {
            echo "Invalid role selected.";
            exit;
        }

        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify password
        if ($user && password_verify($password, $user['password'])) {
            // Set session variables for the user
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $role;

            // Redirect to appropriate dashboard
            if ($role === 'patient') {
                header("Location: patient_dashboard.php");
            } elseif ($role === 'doctor') {
                header("Location: clinic_dashboard.php");
            }
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "Please select a valid role.";
    }
}
?>

<!-- Login Form (HTML) -->
<form method="POST" action="login.php">
    <label>Select your role:</label><br>
    <input type="radio" name="role" value="patient" required> Patient<br>
    <input type="radio" name="role" value="doctor" required> Doctor<br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <input type="submit" value="Login">
</form>

<p>Don't have an account? <a href="register.php">Register here</a></p>
