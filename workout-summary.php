<?php
include 'config.php';

// Retrieve all workouts with user information
$sql = "
    SELECT u.name AS user_name, w.workout_type, w.date, w.duration, w.details 
    FROM workouts w 
    JOIN users u ON w.user_id = u.id
    ORDER BY u.name, w.date DESC
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout Summary</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Workout Summary</h1>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Workout Type</th>
                    <th>Date</th>
                    <th>Duration (minutes)</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['workout_type']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td><?php echo htmlspecialchars($row['duration']); ?></td>
                    <td><?php echo htmlspecialchars($row['details']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</body>
</html>

<?php $conn->close(); ?>
