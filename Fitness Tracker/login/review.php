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
    $current_user_id = $_SESSION['user_id'];
    $role_check_sql = "SELECT role FROM users WHERE id = $current_user_id";
    $role_result = $conn->query($role_check_sql);
    $current_user_role = $role_result->fetch_assoc()['role'];

    if ($current_user_role !== 'admin') {
        header("Location: dashboard.php");
        exit();
    }
	

    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $sql = "SELECT * FROM reviews WHERE id = $id";
    $result = $conn->query($sql);
    $review = $result->fetch_assoc();

    if (!$review) {
        echo "<p>Review not found.</p>";
        echo "<div class='back-button'><a href='users.php'>Back to Users</a></div>";
        exit();
    }
    ?>
	
	<!DOCTYPE html>
<html lang="en">
<head>
    <title>Review - <?php echo htmlspecialchars($review['name']); ?></title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .back-button {
            display: block;
            margin: 20px 0;
            text-align: center;
        }
        .back-button a {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
        }
        .back-button a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<?php include 'sidebar.php'?>

    <div class="content">

    <div class="container">
        <h2>Review Details</h2>
        <table>
            <tr>
                <th>ID</th>
                <td><?php echo $review['id']; ?></td>
            </tr>
            <tr>
                <th>Name</th>
                <td><?php echo htmlspecialchars($review['name']); ?></td>
            </tr>
            <tr>
                <th>Rating</th>
                <td><?php echo htmlspecialchars($review['rating']); ?></td>
            </tr>
            <tr>
                <th>Review</th>
                <td><?php echo $review['review']; ?></td>
            </tr>
            <tr>
                <th>status</th>
                <td><?php echo $review['status']; ?> </td>
            </tr>
            <tr>
                <th>Date</th>
                <td><?php echo $review['created_at']; ?> </td>
            </tr>
        
        </table>
        <div class="back-button">
            <a href="reviews.php">Back to Reviews</a>
        </div>
    </div>
	</div>

    <?php $conn->close(); ?>
</body>
</html>
