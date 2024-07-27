<?php
include 'config.php';

$id = $_GET['id'];

$sql = "DELETE FROM workouts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: home.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();
?>
