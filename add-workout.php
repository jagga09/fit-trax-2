<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fitness_tracker";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO workouts (workout_type, date, duration, details) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $workout_type, $date, $duration, $details);

    // Set parameters and execute
    $workout_type = $_POST['workout_type'];
    $date = $_POST['date'];
    $duration = $_POST['duration'];
    $details = $_POST['details'];

    if ($stmt->execute()) {
        echo "New workout added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Workout</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Add New Workout</h1>
    </header>
    <main>
        <form action="add-workout.php" method="post">
            <label for="workout_type">Workout Type:</label>
            <input type="text" id="workout_type" name="workout_type" required><br>
            
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required><br>
            
            <label for="duration">Duration (minutes):</label>
            <input type="number" id="duration" name="duration" min="1" required><br>
            
            <label for="details">Details:</label><br>
            <textarea id="details" name="details" rows="4" cols="50"></textarea><br>
            
            <input type="submit" value="Add Workout">
        </form>
        <a href="home.php">Back to Workout Logs</a>
    </main>
</body>
</html>
