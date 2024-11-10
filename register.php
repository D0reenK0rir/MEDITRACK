<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = $_POST['role'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing the password for security

    try {
        if ($role === 'patient') {
            $stmt = $pdo->prepare("INSERT INTO patients (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
            $stmt->execute([$firstName, $lastName, $email, $password]);
            header("Location: patient_dashboard.html");
        } elseif ($role === 'doctor') {
            $licenseNumber = $_POST['license_number'];
            $stmt = $pdo->prepare("INSERT INTO doctors (first_name, last_name, email, password, license_number) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$firstName, $lastName, $email, $password, $licenseNumber]);
            header("Location: clinic_dashboard.html");
        } else {
            echo "Please select a valid role.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

