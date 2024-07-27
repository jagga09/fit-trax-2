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

// Check if ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute SQL statement
    $stmt = $conn->prepare("SELECT * FROM workouts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the record
    $workout = $result->fetch_assoc();

    if (!$workout) {
        echo "No workout found with ID " . htmlspecialchars($id);
        exit;
    }

    // Close statement
    $stmt->close();
} else {
    echo "No ID provided.";
    exit;
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Workout</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>View Workout</h1>
    </header>
    <main>
        <h2>Workout Details</h2>
        <p><strong>ID:</strong> <?php echo htmlspecialchars($workout['id']); ?></p>
        <p><strong>Workout Type:</strong> <?php echo htmlspecialchars($workout['workout_type']); ?></p>
        <p><strong>Date:</strong> <?php echo htmlspecialchars($workout['date']); ?></p>
        <p><strong>Duration:</strong> <?php echo htmlspecialchars($workout['duration']); ?> minutes</p>
        <p><strong>Details:</strong> <?php echo htmlspecialchars($workout['details']); ?></p>

        <a href="update-workout.php?id=<?php echo htmlspecialchars($workout['id']); ?>">Update Workout</a>
        <a href="delete-workout.php?id=<?php echo htmlspecialchars($workout['id']); ?>">Delete Workout</a>
        <a href="home.php">Back to Workout Logs</a>
    </main>
</body>
</html>
