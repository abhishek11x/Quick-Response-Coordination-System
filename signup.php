<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .signup-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .links {
            text-align: center;
            margin-top: 15px;
        }
        .links a {
            color: #4CAF50;
            text-decoration: none;
        }
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #dff0d8;
            border: 1px solid #d0e9c6;
            color: #3c763d;
        }
        .alert-danger {
            background-color: #f2dede;
            border: 1px solid #ebcccc;
            color: #a94442;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2 style="text-align: center;">Sign Up</h2>
        <?php
        session_start();
        require_once 'config.php';
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            
            if ($username && $email && $password && $confirm_password) {
                if ($password === $confirm_password) {
                    // Check if username already exists
                    $check_user = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' OR email = '$email'");
                    
                    if (mysqli_num_rows($check_user) > 0) {
                        echo "<div class='alert alert-danger'>Username or email already exists!</div>";
                    } else {
                        // Hash password
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        
                        // Insert new user
                        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
                        
                        if (mysqli_query($conn, $sql)) {
                            echo "<div class='alert alert-success'>Registration successful! You can now <a href='login.php'>login</a>.</div>";
                        } else {
                            echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
                        }
                    }
                } else {
                    echo "<div class='alert alert-danger'>Passwords do not match!</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Please fill in all fields!</div>";
            }
        }
        ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn">Sign Up</button>
        </form>
        <div class="links">
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>
</body>
</html>
