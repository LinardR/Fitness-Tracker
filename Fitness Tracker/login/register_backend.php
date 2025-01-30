<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "fitness_app";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $fitness_goals = $_POST['fitness_goals'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); 

    $sql = "INSERT INTO users (name, age, weight, height, fitness_goals, email, password)
            VALUES ('$name', '$age', '$weight', '$height', '$fitness_goals', '$email', '$password')";

try {
    if ($conn->query($sql) === TRUE) {
        header("Location: /login");
        exit();
    } else {
        throw new Exception("Error executing query: " . $conn->error);
    }
} catch (Exception $e) {
    echo "Exception caught: " . $e->getMessage();
}

    $conn->close();
}
?>