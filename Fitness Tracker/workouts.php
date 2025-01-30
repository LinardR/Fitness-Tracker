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

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $date = $_POST['date'];
    $exercise = htmlspecialchars($_POST['exercise']);
    $reps = intval($_POST['reps']);
    $sets = intval($_POST['sets']);

    $sql = "INSERT INTO workouts (user_id, date, exercise, reps, sets) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issii", $user_id, $date, $exercise, $reps, $sets);

    if ($stmt->execute()) {
        $message = "Workout added successfully!";
    } else {
        $message = "Error adding workout: " . $conn->error;
    }
    $stmt->close();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT date, exercise, reps, sets FROM workouts WHERE user_id = ? ORDER BY date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Workouts</title>
  		<link rel="stylesheet" href="assets/css/reset.css">
		<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
	<?php include 'navbar.php'; ?>
  	    <div class="workouts-background cover-bg">
        <h1>Log a New Workout</h1>
		</div>
		
  <section id="log-workout">
     <div class="container">
        <h2>Add Workout</h2>
        <?php if ($message): ?>
            <div class="message"> <?php echo htmlspecialchars($message); ?> </div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-row">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
            </div>

            <div class="form-row">
                <label for="exercise">Exercise:</label>
                <input type="text" id="exercise" name="exercise" placeholder="e.g., Push-ups" required>
            </div>

            <div class="form-row">
                <label for="reps">Reps:</label>
                <input type="number" id="reps" name="reps" min="1" placeholder="e.g., 20" required>
            </div>

            <div class="form-row">
                <label for="sets">Sets:</label>
                <input type="number" id="sets" name="sets" min="1" placeholder="e.g., 3" required>
            </div>

            <div class="form-row">
                <button type="submit">Add Workout</button>
            </div>
        </form>
    </div>
  </section>

  <section id="workout-history">
    <h2>Workout History</h2>
       <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Exercise</th>
                    <th>Reps</th>
                    <th>Sets</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                        <td><?php echo htmlspecialchars($row['exercise']); ?></td>
                        <td><?php echo $row['reps']; ?></td>
                        <td><?php echo $row['sets']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
  </section>
<?php $conn->close(); ?>

<?php include 'footer.php'; ?>

</body>
</html>
