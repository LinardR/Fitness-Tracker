<?php
session_start();

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "fitness_app";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->close();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Fitness Tracker</title>
	<link rel="stylesheet" href="assets/css/reset.css">
	<link rel="stylesheet" href="assets/css/style.css">

</head>
<?php include 'navbar.php'; ?>

<body>

	<div class="container">


		
		  	    <div class="text-background cover-bg">
        <h1>Welcome to Fitness Tracker</h1>
        <p>Track your workouts, monitor progress, and achieve your fitness goals!</p>
		</div>
	

<main>
  <section>
<a href="profile.php">   
   <h2>User Profile</h2>
    <p>Manage your personal details, fitness goals, and app preferences.</p>
	</a>
  </section>

  <section>
  <a href="workouts.php">  
    <h2>Workouts</h2>
    <p>Log and view workout routines, exercises, and training plans.</p>
	</a>
  </section>

  <section>
    <a href="progress.php">
    <h2>Progress Tracker</h2>
    <p>Track your fitness journey with graphs, stats, and achievements.</p>
	</a>
  </section>

  <section>
    <a href="community.php">
    <h2>Community</h2>
    <p>Join forums, participate in challenges, and connect with others.</p>
	</a>
  </section>

  <section>
    <a href="contact.php">
    <h2>Contact</h2>
    <p>Track your meals, calories, and access diet plans.</p>
	</a>
  </section>

  <section>
  <a href="about.php">
    <h2>About</h2>
    <p>Customize your app preferences, notifications, and privacy settings.</p>
	</a>
  </section>
</main>
	
	
</div>

<?php include 'footer.php'; ?>

</body>
</html>
