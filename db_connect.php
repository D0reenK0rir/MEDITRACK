<?php
// Database credentials
$host = 'localhost';
$dbname = 'meditrack';
$username = 'root';  // Change to your MySQL username
$password = '';      // Change to your MySQL password

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode to exceptions
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
