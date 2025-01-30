<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .sidebar {
            width: 200px;
            background-color: #333;
            color: #fff;
            height: 100vh;
            padding: 15px 0;
            position: fixed;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .sidebar ul li {
            padding: 10px 20px;
        }
        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
            display: block;
        }
        .sidebar ul li a:hover {
            background-color: #575757;
            border-radius: 4px;
        }
        .content {
            margin-left: 200px;
            padding: 20px;
            flex-grow: 1;
        }
        .logout {
            text-align: right;
            margin-bottom: 10px;
        }
        .logout a {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }
        .logout a:hover {
            text-decoration: underline;
        }
		
		        .dashboard-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }
        .dashboard-box {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 200px;
            text-align: center;
        }
        .dashboard-box h3 {
            margin: 0;
            font-size: 18px;
        }
        .dashboard-box p {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }
		
		
    </style>
</head>
<body>
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

$user_count_query = "SELECT COUNT(*) as total_users FROM users";
$review_count_query = "SELECT COUNT(*) as total_reviews FROM reviews";
$contact_count_query = "SELECT COUNT(*) as total_contacts FROM contact_requests";

$user_count = $conn->query($user_count_query)->fetch_assoc()['total_users'];
$review_count = $conn->query($review_count_query)->fetch_assoc()['total_reviews'];
$contact_count = $conn->query($contact_count_query)->fetch_assoc()['total_contacts'];

?>
	
	

<?php include 'sidebar.php'?>


    <div class="content">
        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>
				 <h2>Admin Dashboard</h2>

        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>
        
		
    <div class="dashboard-container">
        <div class="dashboard-box">
            <h3>Total Users</h3>
            <p><?php echo $user_count; ?></p>
        </div>
        <div class="dashboard-box">
            <h3>Total Reviews</h3>
            <p><?php echo $review_count; ?></p>
        </div>
        <div class="dashboard-box">
            <h3>Contact Requests</h3>
            <p><?php echo $contact_count; ?></p>
        </div>
    </div>
		
    </div>
</body>
</html>
