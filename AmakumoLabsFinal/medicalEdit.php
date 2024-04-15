<?php

    session_start();
    
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
<html lang="en">

<head>
    <title>Amakumo Medical Labs</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
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
        
		<div class="container mt-5">
    
    <div class="container">
        <h1>Welcome to the AmaLabs Management System</h1>
        <br><br>
    </div>
    
    <form action="process.php" method="post">
    
        <div class="form-group">
            <label for="visit_ID">Visit ID:</label>
            <input type="text" class="form-control" id="visit_ID" name="visit_ID" placeholder="Enter ID (for Update, Delete, Query by ID)" >
        </div>
        
        <div class="form-group">
            <label for="exam_date">Exam Date:</label>
            <input type="date" class="form-control" id="exam_date" name="exam_date" >
        </div>
        
        <div class="form-group">
            <label for="doctor_visited">Doctor Visited:</label>
            <input type="text" class="form-control" id="doctor_visited" name="doctor_visited" maxlength="50">
        </div>
        
        <div class="form-group">
            <label for="patient_HN">Patient HN:</label>
            <input type="text" class="form-control" id="patient_HN" name="patient_HN" maxlength="9" placeholder="Enter 9 Digit Health Number (for Update, Query by Heath Number)">
        </div>
        
        <div class="form-group">
            <label for="patient_full_name">Patient Full Name:</label>
            <input type="text" class="form-control" id="patient_full_name" name="patient_full_name" maxlength="100">
        </div>
        
        <div class="form-group">
            <label for="exam_item">Exam Item:</label>
            <input type="text" class="form-control" id="exam_item" name="exam_item" maxlength="100">
        </div>
        
        <div class="form-group">
            <label for="exam_results">Exam Results:</label>
            <textarea class="form-control" id="exam_results" name="exam_results" rows="4" cols="50"></textarea>
        </div>

        
        <!-- Buttons for Create, Update, Delete, Query All, Query by Health Number, Query by ID -->
        <button type="submit" name="action" value="create" class="btn btn-success">Create</button>
        <button type="submit" name="action" value="update" class="btn btn-warning">Update</button>
        <button type="submit" name="action" value="delete" class="btn btn-danger">Delete</button>
        <button type="submit" name="action" value="queryAll" class="btn btn-info">Query All</button>
        <button type="submit" name="action" value="queryHN" class="btn btn-primary">Query by Health Number</button>
        <button type="submit" name="action" value="queryId" class="btn btn-secondary">Query by ID</button>
    </form>
    
    <br>
    <?php
        // Display the query results if they exist
        if (isset($_SESSION['results'])) {
            echo "<table class='table table-bordered'>";
            
            echo "<thead><tr><th>Visit ID</th><th>Exam Date</th><th>Doctor Visited</th><th>Patient HN</th><th>Patient Full Name</th><th>Exam Item</th><th>Exam Results</th></tr></thead>";
            
            echo "<tbody>";
            
            foreach ($_SESSION['results'] as $row) {
                echo "<tr>";
                echo "<td>" . $row['visit_ID'] . "</td>";
                echo "<td>" . $row['exam_date'] . "</td>";
                echo "<td>" . $row['doctor_visited'] . "</td>";
                echo "<td>" . $row['patient_HN'] . "</td>";
                echo "<td>" . $row['patient_full_name'] . "</td>";
                echo "<td>" . $row['exam_item'] . "</td>";
                echo "<td>" . $row['exam_results'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
            unset($_SESSION['results']); 
        }
    ?>
    
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