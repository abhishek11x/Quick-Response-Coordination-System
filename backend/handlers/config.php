<?php
header('Content-Type: application/json');
session_start();

$db_host = "localhost";
$db_user = "root";
$db_pass = "3132Num###"; // If you have set a password for MySQL root user, put it here
$db_name = "user_auth";

try {
    $conn = new mysqli($db_host, $db_user, $db_pass);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS $db_name";
    if (!$conn->query($sql)) {
        throw new Exception("Error creating database: " . $conn->error);
    }

    $conn->select_db($db_name);
    
    // Create users table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if (!$conn->query($sql)) {
        throw new Exception("Error creating table: " . $conn->error);
    }

} catch (Exception $e) {
    die(json_encode(['error' => $e->getMessage()]));
}
?>
