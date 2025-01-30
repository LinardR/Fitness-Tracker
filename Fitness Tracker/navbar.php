

<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fitness_app";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$settings_query = "SELECT site_name, footer_text, site_logo FROM site_settings WHERE id = 1";
$settings_result = $conn->query($settings_query);
$settings = $settings_result->fetch_assoc();

$site_name = $settings['site_name'] ?? "Default Site Name";
$footer_text = $settings['footer_text'] ?? "Default Footer Text";
$site_logo = $settings['site_logo'] ?? "Logo";
?>

<header>
<style>
   .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo-preview {
            max-width: 200px;
            height: auto;
            display: block;
            margin: 0 auto;
        }
</style>
<div class="logo"><a  href="index.php"><img class="logo-preview" src="/login/<?php echo $site_logo; ?>"/></a></div>

	
	


<nav class="nav-links">
    <a href="profile.php">Profile</a>
    <a href="workouts.php">Workouts</a>
    <a href="progress.php">Progress</a>
    <a href="community.php">Community</a>
    <a href="contact.php">Contact</a>
    <a href="about.php">About</a>
	<?php

if (!empty($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($role);
    $stmt->fetch();
    $stmt->close();

    if ($role === 'admin') {
        echo '<a href="/login/dashboard.php" style="color:#007bff; font-weight:bold;">Admin</a>';
    }
}
?>
</nav>




<div class="auth-links">
    <?php if (isset($_SESSION['user_id'])): ?>
			<?php
			$name = $_SESSION['name'] ?? 'User'; 
			?>
        <span>Hello, <strong><?php echo htmlspecialchars($name); ?></strong>!</span>&nbsp;
        <form method="POST" action="login/logout.php" style="display: inline;">
            <button style="background-color: #ffffff;color: #000000;cursor: pointer;" type="submit">Logout</button>
        </form>
    <?php else: ?>
        <a href="/login/">Login</a>
        <a href="/login/register.php">Register</a>
    <?php endif; ?>
</div>
    </header>