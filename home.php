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

// Fetch workout logs
$sql = "SELECT * FROM workouts";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Tracker - Workout Logs</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Workout Logs</h1>
    </header>
    <main>
        <a href="add-workout.php">Add New Workout</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Workout Type</th>
                    <th>Date</th>
                    <th>Duration (min)</th>
                    <th>Details</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["workout_type"] . "</td>";
                        echo "<td>" . $row["date"] . "</td>";
                        echo "<td>" . $row["duration"] . "</td>";
                        echo "<td>" . $row["details"] . "</td>";
                        echo "<td>
                                <a href='view-workout.php?id=" . $row["id"] . "'>View</a> |
                                <a href='update-workout.php?id=" . $row["id"] . "'>Update</a> |
                                <a href='delete-workout.php?id=" . $row["id"] . "'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No workouts found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
