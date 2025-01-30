


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
$about_query = "SELECT about_text FROM site_settings WHERE id = 1";
$about_result = $conn->query($about_query);
$about = $about_result->fetch_assoc();

$conn->close();

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <title>Fitness Tracker - About</title>
		  	<link rel="stylesheet" href="assets/css/reset.css">
			<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
	<?php include 'navbar.php'; ?>

		<div class="settings-background cover-bg">
        <h1>About</h1>
		</div>
<section id="settings">
    <div class="container">
        <h2>About Us</h2>
<p><?php echo nl2br($about['about_text']); ?></p>

    </div>
		</section>
		
<?php include 'footer.php'; ?>

</body>
</html>
