<?php
include 'db.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the role is set
    if (!isset($_POST['role'])) {
        echo json_encode(['status' => 'error', 'message' => 'Please select a valid role.']);
        exit;
    }

    // Retrieve form data
    $role = $_POST['role'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Optional license number for doctors
    $licenseNumber = isset($_POST['license_number']) ? $_POST['license_number'] : null;

    try {
        // Prepare the SQL query for inserting a new user
        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password, role, license_number) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$firstName, $lastName, $email, $password, $role, $licenseNumber]);

        echo json_encode(['status' => 'success', 'message' => 'Registration successful.']);
    } catch (PDOException $e) {
        // Handle duplicate email error or any other database errors
        if ($e->getCode() == 23000) { // 23000 is the SQLSTATE code for duplicate entry
            echo json_encode(['status' => 'error', 'message' => 'Email already exists.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}
?>
