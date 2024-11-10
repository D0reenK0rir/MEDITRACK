<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = $_POST['role'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        if ($role === 'patient') {
            $stmt = $pdo->prepare("SELECT * FROM patients WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                header("Location: patient_dashboard.html");
            } else {
                echo "Invalid email or password.";
            }
        } elseif ($role === 'doctor') {
            $stmt = $pdo->prepare("SELECT * FROM doctors WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                header("Location: clinic_dashboard.html");
            } else {
                echo "Invalid email or password.";
            }
        } else {
            echo "Please select a valid role.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
