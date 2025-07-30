<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!$data) {
        echo json_encode(['error' => 'Invalid input data']);
        exit;
    }

    $email = $conn->real_escape_string($data['email']);
    $password = $data['password'];
    
    if ($email && $password) {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];
                
                echo json_encode([
                    'success' => true,
                    'user' => [
                        'email' => $user['email'],
                        'firstName' => $user['first_name'],
                        'lastName' => $user['last_name']
                    ]
                ]);
            } else {
                echo json_encode(['error' => 'Invalid password']);
            }
        } else {
            echo json_encode(['error' => 'User not found']);
        }
    } else {
        echo json_encode(['error' => 'Please fill in all fields']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
