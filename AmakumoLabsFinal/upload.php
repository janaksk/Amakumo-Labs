<?php
    session_start();
    
    // Auto Redirecting Users to Login Page as Session Starts
    if (!isset($_SESSION["user"])) {
       header("Location: login.php");
       exit();
    }
    
    if ($_SESSION["user_type"] === "patient") {
        header("Location: logout.php");
        exit();
    }
    
?>

<!DOCTYPE html>
<html>
<head>
    <title>File Upload and Display</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="ClinicCSS.css">
</head>
<body>
    <div id="container">
	
        <header>
        <h1>Amakumo Medical Labs</h1>
		<h4>Live life like you never lost anything!</h4>
        </header>
       <nav>
	          <br><br>
		      <ul style="list-style-type: none">
		          <li><a href="index.php">Dashboard<br><desc>Return to the user dashboard.</desc></a></li><br>
		          <li><a href="medicalEdit.php">Medical Data<br><desc>Edit Medical Data Here</desc></a></li><br>
		          <li><a href="upload.php">Upload Files<br><desc>Upload Files</desc></a></li><br>
				  <br>
				  <li><a>Logout Below<br><desc>Return to main login page</desc></a></li>
				  <li><a href="logout.php" class="btn btn-warning">Logout</a></li>
			  </ul>
	   </nav>

        <main>
    
    <!-- Creating bootstrap container for code --> 
    
    
    
    <div class="container mt-5">
    
        
        <h2>File Upload and Display</h2>
        <br><br>
        

        <?php
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        $uploadDir = 'uploaded-folder/'; // Instanciating Upload Directory
        
        $allowedTypes = array('text/plain'); // Only allowing .txt files

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            // Checking Directory Exists, If it doesnt exist, creating it
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir);
            }

            foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
                $fileName = $_FILES['files']['name'][$key];
                $fileType = $_FILES['files']['type'][$key];
                $fileSize = $_FILES['files']['size'][$key];

                // Sanitize file name
                $fileName = preg_replace("/[^A-Za-z0-9\_\-\.]/", '_', $fileName);

                // Check file type and size
                if (in_array($fileType, $allowedTypes) && $fileSize <= 5242880) { // Max file size: 5 MB
                    $filePath = $uploadDir . $fileName;
                    move_uploaded_file($tmp_name, $filePath);
                }
            }
        }

        // DISPLAYING FILES AND ALSO CREATING CLICKABLE LINKS
        
        // Scanning Directory For uploaded files
        $uploadedFiles = scandir($uploadDir);
        
        // We check to see if there are actually files before displaying the table
        if (count($uploadedFiles) > 2) { 
            
            echo '<h3>Uploaded Files</h3>';
            echo '<table class="table">';
            echo '<thead><tr><th>File Name</th></tr></thead><tbody>';
            
            foreach ($uploadedFiles as $file) {
                if ($file != '.' && $file != '..') {
                    echo '<tr>';
                    echo '<td><a href="?file=' . urlencode($file) . '">' . $file . '</a></td>';
                    echo '</tr>';
                }
            }
            echo '</tbody></table>';
        }

        // Display the file content if a file is selected
        
        if (isset($_GET['file'])) {
            $file = $_GET['file'];
            $filePath = 'uploaded-folder/' . $file;

            if (file_exists($filePath) && is_readable($filePath)) {
                echo '<h3>File Content</h3>';
                echo '<pre>' . htmlspecialchars(file_get_contents($filePath)) . '</pre>';
                
            } else {
                echo 'File not found or not readable.';
            }
        }
        
        ?>

        <!-- File upload form -->
        
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="files[]" multiple accept=".txt"> <!-- Only allow .txt files -->
            <button type="submit" class="btn btn-primary">Upload Files</button>
        </form>
    </div>
    
</main>
<footer>
    <br>
    Copyright © 2023 Amakumo Medical Group<br>
    <a href="mailto:michealmcdoesntexist@gmail.com">
    amakumomedical@gmail.com</a>
  	<br>
    290-262-5866<br>
    15738 Ascher Lane<br>
    V3V 1T5<br>
    Tsutaiyo, NS<br>
</footer>
</div>
</body>
</html>