<?php
$servername = "kg-gopinathan-cis252.ctj4hvirfb3t.us-east-2.rds.amazonaws.com";
$username = "admin";
$password = "Placement17";
$dbname = "StudentRegistration";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
