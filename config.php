<?php
$db_host = "127.0.0.1:3307";  
$db_user = "root";
$db_pass = "";
$db_name = "user_auth";

$conn = mysqli_connect($db_host, $db_user, $db_pass);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $db_name";
if (mysqli_query($conn, $sql)) {
    mysqli_select_db($conn, $db_name);
    
    // Create users table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if (!mysqli_query($conn, $sql)) {
        die("Error creating table: " . mysqli_error($conn));
    }
} else {
    die("Error creating database: " . mysqli_error($conn));
}
?>
