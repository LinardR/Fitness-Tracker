<?php
session_start();

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "fitness_app";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message_content = htmlspecialchars($_POST['message']);
    
    $insert_contact_query = "INSERT INTO contact_requests (name, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_contact_query);
    $stmt->bind_param("sss", $name, $email, $message_content);
    
    if ($stmt->execute()) {
        $message = "Your message has been sent successfully!";

        $to = "postmaster@localhost";
        $subject = "New Contact Request";
        $headers = "From: " . $email . "\r\n" .
                   "Reply-To: " . $email . "\r\n" .
                   "Content-Type: text/plain; charset=UTF-8";
        
        $email_message = "You have received a new contact request:\n\n";
        $email_message .= "Name: " . $name . "\n";
        $email_message .= "Email: " . $email . "\n";
        $email_message .= "Message: " . $message_content . "\n";
        
        mail($to, $subject, $email_message, $headers);
    } else {
        $message = "Error submitting your request: " . $conn->error;
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact - Fitness Tracker</title>
		  	<link rel="stylesheet" href="assets/css/reset.css">
			<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
	<?php include 'navbar.php'; ?>

		<div class="nutrition-background cover-bg">
        <h1>Contact</h1>
		</div>
	<section id="contact">


        <h2>Contact Us</h2>
            <form method="POST">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <textarea name="message" placeholder="Your Message" required></textarea>
                <button type="submit" name="contact_submit">Send Message</button>
            </form>
            <?php if ($message): ?>
                <p><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>




 

	</section>

<?php include 'footer.php'; ?>

</body>
</html>
