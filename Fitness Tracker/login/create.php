<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
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
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input, textarea, select {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
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
    $current_user_id = $_SESSION['user_id'];
    $role_check_sql = "SELECT role FROM users WHERE id = $current_user_id";
    $role_result = $conn->query($role_check_sql);
    $current_user_role = $role_result->fetch_assoc()['role'];

    if ($current_user_role !== 'admin') {
        header("Location: dashboard.php");
        exit();
    }
	
	

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $age = $_POST['age'];
        $weight = $_POST['weight'];
        $height = $_POST['height'];
        $fitness_goals = $_POST['fitness_goals'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (name, age, weight, height, fitness_goals, email, password) VALUES ('$name', $age, $weight, $height, '$fitness_goals', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>User created successfully!</p>";
        } else {
            echo "<p>Error creating user: " . $conn->error . "</p>";
        }
    }

    $conn->close();
    ?>
<?php include 'sidebar.php'?>
<div class="content">
    <div class="container">
        <h2>Create User</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="number" name="age" placeholder="Age" required>
            <input type="number" step="0.01" name="weight" placeholder="Weight (kg)" required>
            <input type="number" step="0.01" name="height" placeholder="Height (cm)" required>
            <textarea name="fitness_goals" placeholder="Fitness Goals" required></textarea>
			<select name="role" id="role">
  <option value="user">User</option>
  <option value="admin">Admin</option>
</select>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Create</button>
        </form>
        <a href="users.php">Back to Users</a>
    </div>
	</div>
</body>
</html>