<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Retrieve user details from the database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if user exists and if password is correct
        if ($user && password_verify($password, $user['password'])) {
            // Set session variables for user authentication and personalization
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['first_name'] = $user['first_name']; // Store first name
            $_SESSION['last_name'] = $user['last_name'];   // Store last name

            // Redirect based on the user's role
            if ($user['role'] === 'patient') {
                header("Location: patientdashboard.php");
            } elseif ($user['role'] === 'doctor') {
                header("Location: doctordashboard.php");
            }
            exit; // Ensure no further code runs after redirection
        } else {
            echo "Invalid email or password.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
