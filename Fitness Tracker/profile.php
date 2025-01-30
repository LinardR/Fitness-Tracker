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

$sql = "SELECT name, age, weight, height, fitness_goals FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $age = intval($_POST['age']);
    $weight = floatval($_POST['weight']);
    $height = floatval($_POST['height']);
    $goals = htmlspecialchars($_POST['goals']);

    $update_sql = "UPDATE users SET name = ?, age = ?, weight = ?, height = ?, fitness_goals = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("siidsi", $name, $age, $weight, $height, $goals, $user_id);

     if ($stmt->execute()) {
        $message = "Profile updated successfully!";
    } else {
        $message = "Error updating profile: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>
		<link rel="stylesheet" href="assets/css/reset.css">
		<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
<?php include 'navbar.php'; ?>

	  
  	    <div class="profile-background cover-bg">
        <h1>User Profile</h1>
		
	
		<p>Manage your personal details, fitness goals, and app preferences here.</p>
		</div>
		

  
  
  <section id="profile">
  
  	<?php if ($message): ?>
            <div class="message <?php echo strpos($message, 'Error') !== false ? 'error' : ''; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
  <p>Fill out your profile information to personalize your fitness journey:</p>
  
  

        <form id="profile-form" method="POST">
            <div class="form-row">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" placeholder="Enter your name" required>
            </div>

            <div class="form-row">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" value="<?php echo $user['age']; ?>" min="1" placeholder="Enter your age" required>
            </div>

            <div class="form-row">
                <label for="weight">Weight (kg):</label>
                <input type="number" id="weight" name="weight" value="<?php echo $user['weight']; ?>" min="1" placeholder="Enter your weight" required>
            </div>

            <div class="form-row">
                <label for="height">Height (cm):</label>
                <input type="number" id="height" name="height" value="<?php echo $user['height']; ?>" min="1" placeholder="Enter your height" required>
            </div>

            <div class="form-row">
                <label for="goals">Fitness Goals:</label>
                <textarea id="goals" name="goals" placeholder="Describe your fitness goals..." required><?php echo htmlspecialchars($user['fitness_goals']); ?></textarea>
            </div>

            <div class="form-row">
                <button type="submit">Save Profile</button>
            </div>
        </form>
</section>



  <section id="profile-display" style="display: none;">
    <h2>Your Profile</h2>

    <div class="profile-row"><p><strong>Name:</strong> <span id="display-name"></span></p></div>
    <div class="profile-row"><p><strong>Age:</strong> <span id="display-age"></span></p></div>
    <div class="profile-row"><p><strong>Weight:</strong> <span id="display-weight"></span> kg</p></div>
    <div class="profile-row"><p><strong>Height:</strong> <span id="display-height"></span> cm</p></div>
    <div class="profile-row"><p><strong>Goals:</strong> <span id="display-goals"></span></p></div>
    <button id="edit-profile">Edit Profile</button>
  </section>

<?php include 'footer.php'; ?>



</body>
</html>