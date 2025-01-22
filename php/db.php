<?php
// Database configuration
$host = "explorer-center.czscsemm4fbv.eu-north-1.rds.amazonaws.com"; // Server hostname (default for XAMPP is localhost)
$username = "admin"; // Default username for XAMPP
$password = "ExplorerCenter123"; // Default password for XAMPP (usually empty)
$dbname = "explorer_center"; // Your database name

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>