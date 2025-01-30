<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact List</title>
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
        .actions button {
            padding: 5px 10px;
            margin-right: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .actions .show {
            background-color: #007bff;
            color: white;
        }
        .actions .update {
            background-color: #ffc107;
            color: white;
        }
        .actions .delete {
            background-color: #dc3545;
            color: white;
        }
		 .create {
            background-color: green;
            color: white;
			padding: 5px 10px;
			margin-right: 5px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
        }
    </style>
</head>
<body>
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
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

$contact_query = "SELECT id, name, email, message, submitted_at FROM contact_requests ORDER BY submitted_at DESC";
$contact_result = $conn->query($contact_query);

?>

<?php include 'sidebar.php'?>

    <div class="content">
        <h2>Contact Requests</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($contact_result->num_rows > 0): ?>
                    <?php while ($row = $contact_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['message']); ?></td>
                            <td><?php echo date('M d, Y H:i', strtotime($row['submitted_at'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No contact requests found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php $conn->close(); ?>
</body>
</html>