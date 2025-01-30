<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
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
		
    $user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $delete_sql = "DELETE FROM users WHERE id = $user_id";
        if ($conn->query($delete_sql) === TRUE) {
            echo "<p>User deleted successfully.</p>";
        } else {
            echo "<p>Error deleting user: " . $conn->error . "</p>";
        }
    } else {
        echo "<p>User not found.</p>";
    }

    $conn->close();
    ?>

    <a href="users.php">Back to Users</a>
</body>
</html>