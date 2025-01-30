<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
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
        input, textarea {
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
        .role-select {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
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

    $user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    if (!$user) {
        echo "<p>User not found.</p>";
        echo "<a href='users.php'>Back to Users</a>";
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $age = $_POST['age'];
        $weight = $_POST['weight'];
        $height = $_POST['height'];
        $fitness_goals = $_POST['fitness_goals'];
        $role = $_POST['role'];

        $update_sql = "UPDATE users SET name = '$name', age = $age, weight = $weight, height = $height, fitness_goals = '$fitness_goals', role = '$role' WHERE id = $user_id";

        if ($conn->query($update_sql) === TRUE) {
            echo "<p>User updated successfully!</p>";
        } else {
            echo "<p>Error updating user: " . $conn->error . "</p>";
        }
    }
    ?>

<?php include 'sidebar.php'?>

    <div class="content">
        <div class="container">
            <h2>Update User</h2>
            <form method="POST">
                <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                <input type="number" name="age" value="<?php echo $user['age']; ?>" required>
                <input type="number" step="0.01" name="weight" value="<?php echo $user['weight']; ?>" required>
                <input type="number" step="0.01" name="height" value="<?php echo $user['height']; ?>" required>
                <textarea name="fitness_goals" required><?php echo htmlspecialchars($user['fitness_goals']); ?></textarea>
                <select name="role" class="role-select" required>
                    <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
                    <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                </select>
                <button type="submit">Update</button>
            </form>
            <a href="users.php">Back to Users</a>
        </div>
    </div>

    <?php $conn->close(); ?>
</body>
</html>
