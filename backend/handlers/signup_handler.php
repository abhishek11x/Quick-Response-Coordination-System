<?php
require_once 'config.php';

// Debug logging
error_log("Signup request received");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = file_get_contents('php://input');
    error_log("Raw input: " . $input);
    
    $data = json_decode($input, true);
    error_log("Decoded data: " . print_r($data, true));
    
    if (!$data) {
        error_log("Invalid input data");
        echo json_encode(['error' => 'Invalid input data']);
        exit;
    }

    $firstName = $conn->real_escape_string($data['firstName']);
    $lastName = $conn->real_escape_string($data['lastName']);
    $email = $conn->real_escape_string($data['email']);
    $password = $data['password'];
    
    error_log("Processing signup for email: " . $email);
    
    if ($firstName && $lastName && $email && $password) {
        // Check if email already exists
        $check_user = $conn->query("SELECT * FROM users WHERE email = '$email'");
        
        if ($check_user->num_rows > 0) {
            error_log("Email already exists: " . $email);
            echo json_encode(['error' => 'Email already exists']);
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert new user
            $sql = "INSERT INTO users (first_name, last_name, email, password) 
                    VALUES ('$firstName', '$lastName', '$email', '$hashed_password')";
            
            error_log("Executing SQL: " . $sql);
            
            if ($conn->query($sql)) {
                $user_id = $conn->insert_id;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['email'] = $email;
                $_SESSION['first_name'] = $firstName;
                $_SESSION['last_name'] = $lastName;
                
                error_log("User created successfully with ID: " . $user_id);
                
                echo json_encode([
                    'success' => true,
                    'user' => [
                        'email' => $email,
                        'firstName' => $firstName,
                        'lastName' => $lastName
                    ]
                ]);
            } else {
                error_log("Database error: " . $conn->error);
                echo json_encode(['error' => $conn->error]);
            }
        }
    } else {
        error_log("Missing required fields");
        echo json_encode(['error' => 'Please fill in all fields']);
    }
} else {
    error_log("Invalid request method: " . $_SERVER["REQUEST_METHOD"]);
    echo json_encode(['error' => 'Invalid request method']);
}
?>
