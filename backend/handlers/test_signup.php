<?php
require_once 'config.php';

$testData = [
    'firstName' => 'Test',
    'lastName' => 'User',
    'email' => 'test@example.com',
    'password' => 'test123'
];

try {
    // Check if email already exists
    $email = $conn->real_escape_string($testData['email']);
    $check_user = $conn->query("SELECT * FROM users WHERE email = '$email'");
    
    if ($check_user->num_rows > 0) {
        echo "Test failed: Email already exists\n";
    } else {
        // Hash password
        $hashed_password = password_hash($testData['password'], PASSWORD_DEFAULT);
        
        // Insert new user
        $sql = "INSERT INTO users (first_name, last_name, email, password) 
                VALUES ('{$conn->real_escape_string($testData['firstName'])}', 
                        '{$conn->real_escape_string($testData['lastName'])}', 
                        '$email', 
                        '$hashed_password')";
        
        if ($conn->query($sql)) {
            echo "Test successful: User created with ID: " . $conn->insert_id . "\n";
        } else {
            echo "Test failed: " . $conn->error . "\n";
        }
    }
} catch (Exception $e) {
    echo "Test error: " . $e->getMessage() . "\n";
}
?>
