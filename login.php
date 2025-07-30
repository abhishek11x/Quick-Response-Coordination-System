<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
        .login-container {
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
    <div class="login-container">
        <h2 style="text-align: center;">Login</h2>
        <?php
        session_start();
        require_once 'config.php';
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $password = $_POST['password'];
            
            if ($username && $password) {
                // Check if user exists
                $sql = "SELECT * FROM users WHERE username = '$username'";
                $result = mysqli_query($conn, $sql);
                
                if ($result && mysqli_num_rows($result) > 0) {
                    $user = mysqli_fetch_assoc($result);
                    
                    if (password_verify($password, $user['password'])) {
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        echo "<div class='alert alert-success'>Login successful! Welcome " . htmlspecialchars($user['username']) . "!</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Invalid password!</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>User not found!</div>";
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
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
        <div class="links">
            <p>Don't have an account? <a href="signup.php">Sign up</a></p>
        </div>
    </div>
</body>
</html>
