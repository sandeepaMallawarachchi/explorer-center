<?php
// Database configuration
$host = "localhost"; // Server hostname (default for XAMPP is localhost)
$username = "root"; // Default username for XAMPP
$password = ""; // Default password for XAMPP (usually empty)
$dbname = "explorer_center"; // Your database name
$port = 3307;

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname, $port);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}