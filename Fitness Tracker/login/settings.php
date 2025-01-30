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

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $site_name = htmlspecialchars($_POST['site_name']);
    $footer_text = htmlspecialchars($_POST['footer_text']);
    $about_text = $_POST['about_text']; 

    
    if (!empty($_FILES['site_logo']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["site_logo"]["name"]);
        
        if (move_uploaded_file($_FILES["site_logo"]["tmp_name"], $target_file)) {
            $site_logo = $target_file;
            $update_query = "UPDATE site_settings SET site_name = ?, footer_text = ?, about_text = ?, site_logo = ? WHERE id = 1";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("ssss", $site_name, $footer_text, $about_text, $site_logo);
        } else {
            $message = "Error uploading file.";
        }
    } else {
        $update_query = "UPDATE site_settings SET site_name = ?, footer_text = ?, about_text = ? WHERE id = 1";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("sss", $site_name, $footer_text, $about_text);
    }

    if ($stmt->execute()) {
        $message = "Settings updated successfully!";
    } else {
        $message = "Error updating settings: " . $conn->error;
    }
}

$settings_query = "SELECT site_name, footer_text, about_text, site_logo FROM site_settings WHERE id = 1";
$settings_result = $conn->query($settings_query);
$settings = $settings_result->fetch_assoc();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .actions button {
            padding: 5px 10px;
            margin-right: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .actions .show {
            background-color: #007bff;
            color: white;
        }
        .actions .update {
            background-color: #ffc107;
            color: white;
        }
        .actions .delete {
            background-color: #dc3545;
            color: white;
        }
		 .create {
            background-color: green;
            color: white;
			padding: 5px 10px;
			margin-right: 5px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
        }
		
 .form-container {
        display: grid;
        grid-template-columns: 1fr 2fr; 
        gap: 15px 10px;
        align-items: center;
    }
    .form-container label {
        font-weight: bold;
        text-align: right;
    }
    .form-container input, .form-container textarea {
        width: 100%; 
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .form-container button {
        grid-column: span 2; 
        background-color: #007bff;
        color: #fff;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
    }
    .form-container button:hover {
        background-color: #0056b3;
    }
	 .form-container textarea {
            width: 100%;
            height: 200px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: vertical;
        }
		    .logo-preview {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
            display: block;
        }
    </style>
</head>
<body>

<?php include 'sidebar.php'?>

    <div class="content">
       

      <h2>Site Settings</h2>
        <?php if ($message): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <div class="form-container">
            <form method="POST" enctype="multipart/form-data">
                <label for="site_name">Site Name:</label>
                <input type="text" name="site_name" value="<?php echo htmlspecialchars($settings['site_name']); ?>" required>
                
                <label for="footer_text">Footer Text:</label>
                <input type="text" name="footer_text" value="<?php echo htmlspecialchars($settings['footer_text']); ?>" required>
                
                <label for="about_text">About Page Text:</label>
                <textarea name="about_text" required><?php echo htmlspecialchars($settings['about_text']); ?></textarea>
                
                <label for="site_logo">Upload Logo:</label>
                <input type="file" name="site_logo" accept="image/*">
                
                <?php if (!empty($settings['site_logo'])): ?>
                    <img src="<?php echo htmlspecialchars($settings['site_logo']); ?>" alt="Site Logo" class="logo-preview">
                <?php endif; ?>
                
                <button type="submit">Save Settings</button>
            </form>
        </div>
	</div>
</body>
</html>