<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /login/");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fitness_app";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $steps = intval($_POST['steps']);
    $calories_burned = intval($_POST['calories_burned']);
    
    $insert_query = "INSERT INTO steps_tracker (user_id, date, steps, calories_burned) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("isii", $user_id, $date, $steps, $calories_burned);
    
    if ($stmt->execute()) {
        $message = "Data submitted successfully!";
    } else {
        $message = "Error submitting data: " . $conn->error;
    }
}

$steps_query = "SELECT date, steps, calories_burned FROM steps_tracker WHERE user_id = ? AND date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) ORDER BY date";
$steps_stmt = $conn->prepare($steps_query);
$steps_stmt->bind_param("i", $user_id);
$steps_stmt->execute();
$steps_result = $steps_stmt->get_result();

$dates = [];
$steps_data = [];
$calories_data = [];
$total_calories = 0;

while ($row = $steps_result->fetch_assoc()) {
    $dates[] = date('M d', strtotime($row['date'])); 
    $steps_data[] = $row['steps'];
    $calories_data[] = $row['calories_burned'];
    $total_calories += $row['calories_burned']; 
}

$total_steps = array_sum($steps_data);

$workouts_query = "SELECT COUNT(*) AS total_workouts FROM workouts WHERE user_id = ?";
$workouts_stmt = $conn->prepare($workouts_query);
$workouts_stmt->bind_param("i", $user_id);
$workouts_stmt->execute();
$workouts_result = $workouts_stmt->get_result()->fetch_assoc();
$total_workouts = $workouts_result['total_workouts'] ?? 0;

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>Fitness Tracker - Progress Tracker</title>
	  	<link rel="stylesheet" href="assets/css/reset.css">
		<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
	<?php include 'navbar.php'; ?>
<div class="progress-background cover-bg">
        <h1>Progress</h1>
		</div>
    <main>
      
        <section id="progress-tracker">
            <h2>Track Your Progress</h2>

            <h3>Submit Your Steps & Calories</h3>
            <form method="POST">
                <input type="date" name="date" required>
                <input type="number" name="steps" placeholder="Enter steps" required>
                <input type="number" name="calories_burned" placeholder="Enter calories burned" required>
                <button type="submit">Submit</button>
            </form>
            <?php if ($message): ?>
                <p><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>
		<br>
		<h3>Your Progress Data</h3>
        <table class="stats-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Steps</th>
                    <th>Calories Burned</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($steps_result as $row): ?>
                    <tr>
                        <td><?php echo date('M d, Y', strtotime($row['date'])); ?></td>
                        <td><?php echo number_format($row['steps']); ?></td>
                        <td><?php echo number_format($row['calories_burned']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
		
            <section id="progress-graphs">
                <h3>Your Progress Graphs</h3>
                <p>Visualize your progress over time:</p>
				        <canvas id="progressChart" width="400" height="200"></canvas>

            </section>

            <section id="stats">
                <h3>Your Fitness Stats</h3>
                <ul>
            <p class="stat-item">Steps this week: <strong><?php echo number_format($total_steps); ?></strong></p>
            <p class="stat-item">Calories burned this week: <strong><?php echo number_format($total_calories); ?></strong></p>
            <p class="stat-item">Workouts completed: <strong><?php echo number_format($total_workouts); ?></strong></p>
                </ul>
            </section>

            <section id="achievements">
                <h3>Your Achievements</h3>
                <p>Celebrate your milestones:</p>
                <ul>
            <p>🏆 Completed the "10,000 Steps a Day Challenge"</p>
            <p>🏅 Achieved a personal best in running: 5K in 25 minutes</p>
            <p>🌟 Logged 30 consecutive days of activity</p>
                </ul>
            </section>
        </section>
    </main>

    <script>
        var ctx = document.getElementById('progressChart').getContext('2d');
        var progressChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($dates); ?>,
                datasets: [
                    {
                        label: 'Steps Per Day',
                        data: <?php echo json_encode($steps_data); ?>,
                        borderColor: '#007bff',
                        backgroundColor: 'rgba(0, 123, 255, 0.2)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Calories Burned Per Day',
                        data: <?php echo json_encode($calories_data); ?>,
                        borderColor: '#ff0000',
                        backgroundColor: 'rgba(255, 0, 0, 0.2)',
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
	
<?php include 'footer.php'; ?>

</body>
</html>
