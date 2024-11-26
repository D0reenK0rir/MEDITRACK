<?php
include 'db.php';

try {
    $stmt = $pdo->prepare("SELECT user_id, first_name, last_name FROM users WHERE role = 'doctor'");
    $stmt->execute();
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
