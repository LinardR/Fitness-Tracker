<?php
session_start();


if (isset($_SESSION['user_id'])) {
    if (isset($_SESSION['redirect_to'])) {
        $redirect_to = $_SESSION['redirect_to'];
        unset($_SESSION['redirect_to']); 
        header("Location: $redirect_to");
    } else {
        header("Location: /index.php"); 
    }
    exit();
}

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "fitness_app";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, name, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
			$_SESSION['name'] = $user['name'];


            if (isset($_SESSION['redirect_to'])) {
                $redirect_to = $_SESSION['redirect_to'];
                unset($_SESSION['redirect_to']); 
                header("Location: $redirect_to");
            } else {
                header("Location: /index.php"); 
            }
            exit();
        } else {
            $error = "Invalid credentials.";
        }
    } else {
        $error = "Invalid credentials.";
    }
}
?>