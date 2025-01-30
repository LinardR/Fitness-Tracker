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
$conn->close();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>Fitness Tracker Community</title>
	  	<link rel="stylesheet" href="assets/css/reset.css">
		<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
	<?php include 'navbar.php'; ?>
<div class="community-background cover-bg">
        <h1>Community</h1>
		</div>
    <main>
        <section id="forums">
            <h2>Reviews</h2>
            <p>Tell us more about your experience</p>
            <form action="/reviews.php" method="POST">
			<div class="stars">
                <label>
                    <input type="radio" name="rating" value="1" class="star-input">
                    <span class="star">&#9733;</span>
                </label>
                <label>
                    <input type="radio" name="rating" value="2" class="star-input">
                    <span class="star">&#9733;</span>
                </label>
                <label>
                    <input type="radio" name="rating" value="3" class="star-input">
                    <span class="star">&#9733;</span>
                </label>
                <label>
                    <input type="radio" name="rating" value="4" class="star-input">
                    <span class="star">&#9733;</span>
                </label>
                <label>
                    <input type="radio" name="rating" value="5" class="star-input">
                    <span class="star">&#9733;</span>
                </label>
            </div>
			<input type="text" name="name" placeholder="Your Name">
                <textarea placeholder="Write a review" id="forum-message" name="review" rows="4" cols="50"></textarea><br>
                <button type="submit">Post</button>
            </form>
        </section>

        <section id="challenges">
            <h2>Reviews</h2>
            <p>Reviews from our clients</p>
          
		  <div class="reviews-container">
        <h2>Recent Reviews</h2>
        
                <?php
				
    $servername = "localhost";
    $username = "root";
    $password = ""; 
    $dbname = "fitness_app";

 
	
	
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $sql = "SELECT name, rating, review, status, created_at FROM reviews WHERE status = 'approved' ORDER BY created_at DESC LIMIT 5";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='review-card'>";
                echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
                echo "<div class='rating'>" . str_repeat("&#9733;", $row['rating']) . str_repeat("&#9734;", 5 - $row['rating']) . "</div>";
                echo "<div class='review-content'>" . htmlspecialchars($row['review']) . "</div>";
                echo "<div class='meta'>Date: " . $row['created_at'] . "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No approved reviews yet.</p>";
        }
        $conn->close();
                ?>
    </div>
		  
        </section>

        
    </main>
<script>
        const stars = document.querySelectorAll('.star');
        const form = document.getElementById('ratingForm');

        stars.forEach((star, index) => {
            star.addEventListener('click', () => {
                stars.forEach(s => s.classList.remove('selected'));
                for (let i = 0; i <= index; i++) {
                    stars[i].classList.add('selected');
                }
            });
        });

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const selectedRating = document.querySelector('input[name="rating"]:checked');
            if (selectedRating) {
                alert(`You rated: ${selectedRating.value} star(s)`);
            } else {
                alert('Please select a rating before submitting.');
            }
        });
    </script>
<?php include 'footer.php'; ?>

</body>
</html>
