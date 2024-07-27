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

    // Prepare and execute SQL statement to fetch current data
    $stmt = $conn->prepare("SELECT * FROM workouts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $workout = $result->fetch_assoc();

    if (!$workout) {
        echo "No workout found with ID " . htmlspecialchars($id);
        exit;
    }

    // Close statement
    $stmt->close();

    // Check if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind SQL statement for update
        $stmt = $conn->prepare("UPDATE workouts SET workout_type = ?, date = ?, duration = ?, details = ? WHERE id = ?");
        $stmt->bind_param("ssisi", $workout_type, $date, $duration, $details, $id);

        // Set parameters and execute
        $workout_type = $_POST['workout_type'];
        $date = $_POST['date'];
        $duration = $_POST['duration'];
        $details = $_POST['details'];

        if ($stmt->execute()) {
            echo "Workout updated successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    }
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
    <title>Update Workout</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Update Workout</h1>
    </header>
    <main>
        <form action="update-workout.php?id=<?php echo htmlspecialchars($workout['id']); ?>" method="post">
            <label for="workout_type">Workout Type:</label>
            <input type="text" id="workout_type" name="workout_type" value="<?php echo htmlspecialchars($workout['workout_type']); ?>" required><br>
            
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($workout['date']); ?>" required><br>
            
            <label for="duration">Duration (minutes):</label>
            <input type="number" id="duration" name="duration" value="<?php echo htmlspecialchars($workout['duration']); ?>" min="1" required><br>
            
            <label for="details">Details:</label><br>
            <textarea id="details" name="details" rows="4" cols="50"><?php echo htmlspecialchars($workout['details']); ?></textarea><br>
            
            <input type="submit" value="Update Workout">
        </form>
        <a href="view-workout.php?id=<?php echo htmlspecialchars($workout['id']); ?>">Back to Workout Details</a>
        <a href="home.php">Back to Workout Logs</a>
    </main>
</body>
</html>
