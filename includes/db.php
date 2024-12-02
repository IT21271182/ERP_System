<?php
$servername = "localhost";
$username = "root";  // Default username
$password = "root";      // Default password
$dbname = "erp_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Database connected successfully!";
?>