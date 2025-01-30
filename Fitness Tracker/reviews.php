<?php

    $servername = "localhost";
    $username = "root";
    $password = ""; 
    $dbname = "fitness_app";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $rating = intval($_POST['rating']);
    $name = htmlspecialchars($_POST['name']);
    $review = htmlspecialchars($_POST['review']);

    if ($rating && $name && $review) {
        $sql = "INSERT INTO reviews (rating, name, review) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $rating, $name, $review);

        if ($stmt->execute()) {
            echo "<p>Thank you for your feedback!</p>";
            echo "<script>setTimeout(() => { window.location.href = 'community.php'; }, 2000);</script>";
        } else {
            echo "<p>There was an error submitting your review: " . $conn->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p>Please fill in all fields correctly.</p>";
    }
}

$conn->close();
?>