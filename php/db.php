<?php
// Database configuration
$host = "explorer-center.czscsemm4fbv.eu-north-1.rds.amazonaws.com"; // Server hostname
$username = "admin"; // Your database username
$password = "ExplorerCenter123"; // Your database password
$dbname = "explorer_center"; // Your database name
$port = 3307;

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname, $port);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}