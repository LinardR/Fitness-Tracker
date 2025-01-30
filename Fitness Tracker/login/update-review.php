<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Review</title>
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
            status: 100vh;
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

	$review_id = isset($_GET['id']) ? intval($_GET['id']) : 0;


	$sql = "SELECT * FROM reviews WHERE id = $review_id";
    $result = $conn->query($sql);
    $review = $result->fetch_assoc();

    if (!$review) {
        echo "<p>Review not found.</p>";
        echo "<a href='reviews.php'>Back to Review</a>";
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $rating = $_POST['rating'];
        $review = $_POST['review'];
        $status = $_POST['status'];
        $update_sql = "UPDATE reviews SET name = '$name', rating = '$rating', review = '$review', status = '$status' WHERE id = $review_id";

        if ($conn->query($update_sql) === TRUE) {
			echo "<script>setTimeout(() => { window.location.href = 'reviews.php'; }, 1000);</script>";
        } else {
            echo "<p>Error updating review: " . $conn->error . "</p>";
        }
    }
    ?>

<?php include 'sidebar.php'?>

    <div class="content">
        <div class="container">
            <h2>Update Review</h2>
            <form method="POST">
                <input type="text" name="name" value="<?php echo htmlspecialchars($review['name']); ?>" required>
                <input type="number" name="rating" value="<?php echo $review['rating']; ?>" required>
                <input type="text"  name="review" value="<?php echo $review['review']; ?>" required>
                <select name="status" class="role-select" required>
                    <option value="not-approved">Not Approved</option>
                    <option value="approved">Approved</option>
                </select>
                <button type="submit">Update</button>
            </form>
            <a href="users.php">Back to Users</a>
        </div>
    </div>

    <?php $conn->close(); ?>
</body>
</html>
