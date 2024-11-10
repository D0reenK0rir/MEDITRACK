<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if role is selected
    if (!isset($_POST['role'])) {
        echo "Please select a valid role.";
        exit;
    }

    $role = $_POST['role'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing the password for security

    // For Doctor: Additional field for license number
    $licenseNumber = isset($_POST['license_number']) ? $_POST['license_number'] : null;

    try {
        // Insert patient into database
        if ($role === 'patient') {
            $stmt = $pdo->prepare("INSERT INTO patients (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
            $stmt->execute([$firstName, $lastName, $email, $password]);
            header("Location: login1.php"); // Redirect to login page after successful registration
        }
        // Insert doctor into database
        elseif ($role === 'doctor') {
            if (!$licenseNumber) {
                echo "Please provide a license number for the doctor.";
                exit;
            }
            $stmt = $pdo->prepare("INSERT INTO doctors (first_name, last_name, email, password, license_number) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$firstName, $lastName, $email, $password, $licenseNumber]);
            header("Location: login1.php"); // Redirect to login page after successful registration
        } else {
            echo "Invalid role selected.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!-- Registration Form (HTML) -->
<form method="POST" action="register1.php">
    <label>Select your role:</label><br>
    <input type="radio" name="role" value="patient" required> Patient<br>
    <input type="radio" name="role" value="doctor" required> Doctor<br><br>

    <label for="first_name">First Name:</label>
    <input type="text" id="first_name" name="first_name" required><br><br>

    <label for="last_name">Last Name:</label>
    <input type="text" id="last_name" name="last_name" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <!-- Additional field for Doctor -->
    <div id="doctor_fields" style="display: none;">
        <label for="license_number">License Number:</label>
        <input type="text" id="license_number" name="license_number"><br><br>
    </div>

    <input type="submit" value="Register">
</form>

<script>
    // Show license number field only when Doctor is selected
    const roleRadios = document.getElementsByName('role');
    roleRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('doctor_fields').style.display = (this.value === 'doctor') ? 'block' : 'none';
        });
    });
</script>
