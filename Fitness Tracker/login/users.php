<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
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
        header("Location: /login/");
        exit();
    }

    $servername = "localhost";
    $username = "root";
    $password = ""; 
    $dbname = "fitness_app";

    $conn = new mysqli($servername, $username, $password, $dbname);
	
    $current_user_id = $_SESSION['user_id'];
    $role_check_sql = "SELECT role FROM users WHERE id = $current_user_id";
    $role_result = $conn->query($role_check_sql);
    $current_user_role = $role_result->fetch_assoc()['role'];

    if ($current_user_role !== 'admin') {
        header("Location: dashboard.php");
        exit();
    }



    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    ?>

<?php include 'sidebar.php'?>

    <div class="content">
        <h2>Users List</h2>
		<?php if ($current_user_role === 'admin'): ?>

		<a href="create.php"><button class="create">Create new User</button></a>
		<?php else: ?>
    <p></p>
<?php endif; ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Weight (kg)</th>
                    <th>Height (cm)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . $row['age'] . "</td>";
                        echo "<td>" . $row['weight'] . "</td>";
                        echo "<td>" . $row['height'] . "</td>";
                        echo "<td class='actions'>";
						echo "<a href='user.php?id=" . $row['id'] . "'><button class='show'>Show</button></a>";
                        echo "<a href='update.php?id=" . $row['id'] . "'><button class='update'>Update</button></a>";
                        echo "<a href='delete.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure?\")'><button class='delete'>Delete</button></a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No users found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php $conn->close(); ?>
</body>
</html>