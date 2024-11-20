<?php
include 'db.php'; // Include database connection file
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
            // Set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on the user's role
            if ($user['role'] === 'patient') {
                header("Location: patientindex.html"); // Redirect to patient dashboard
            } elseif ($user['role'] === 'doctor') {
                header("Location: clinicindex.html"); // Redirect to doctor dashboard
            }
            exit; // Ensure no further code is executed after redirection
        } else {
            // Display an error if the email or password is incorrect
            echo "Invalid email or password.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
