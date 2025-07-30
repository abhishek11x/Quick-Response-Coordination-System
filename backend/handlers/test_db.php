<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "user_auth";

$conn = mysqli_connect($db_host, $db_user, $db_pass);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully to MySQL\n";
    
    // Try to create and select database
    if (mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS $db_name")) {
        echo "Database created or already exists\n";
        
        if (mysqli_select_db($conn, $db_name)) {
            echo "Database selected successfully\n";
            
            // Try to create users table
            $sql = "CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                first_name VARCHAR(50) NOT NULL,
                last_name VARCHAR(50) NOT NULL,
                email VARCHAR(100) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            
            if (mysqli_query($conn, $sql)) {
                echo "Table 'users' created or already exists\n";
                
                // Check if table is accessible
                $result = mysqli_query($conn, "SELECT * FROM users");
                if ($result) {
                    echo "Table 'users' is accessible\n";
                    echo "Number of users: " . mysqli_num_rows($result) . "\n";
                } else {
                    echo "Error accessing table: " . mysqli_error($conn) . "\n";
                }
            } else {
                echo "Error creating table: " . mysqli_error($conn) . "\n";
            }
        } else {
            echo "Error selecting database: " . mysqli_error($conn) . "\n";
        }
    } else {
        echo "Error creating database: " . mysqli_error($conn) . "\n";
    }
}
?>
