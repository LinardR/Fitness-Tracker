<?php

    if (!isset($_SESSION['user_id'])) {
        header("Location: /login/");
        exit();
    }

    $current_user_id = $_SESSION['user_id'];
    $role_check_sql = "SELECT role FROM users WHERE id = $current_user_id";
    $role_result = $conn->query($role_check_sql);
    $current_user_role = $role_result->fetch_assoc()['role'];

    
	?>
		<?php if ($current_user_role === 'admin'): ?>

		    <div class="sidebar">
				<h1>Fitness</h1>

        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="users.php">Users</a></li>
			<li><a href="reviews.php">Reviews</a></li>
			<li><a href="contacts.php">Contacts Request</a></li>
            <li><a href="settings.php">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
		<?php else: ?>

    <div class="sidebar">
		<h1>Fitness</h1>

        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="settings.php">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
<?php endif; ?>