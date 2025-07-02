<?php
// Database configuration
$host = "explorercenter.c0xa4ysyy76b.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "ExplorerCenter123";
$dbname = "explorercenter";

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>