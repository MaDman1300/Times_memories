<?php
session_start();
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM adminusers WHERE username = ?");
    $stmt->bind_param("s", $username);  // Bind the username parameter

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found, check the password
        $row = $result->fetch_assoc();
        
        // Verify the hashed password with the provided password
        if (password_verify($password, $row['password_hash'])) {
            // Password is correct, start the session
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_role'] = $row['role'];  // Optionally store the role

            // Redirect to admin panel
            header("Location: admin_panel.php");
            exit();
        } else {
            // Invalid password
            echo "Invalid username or password.";
        }
    } else {
        // No user found
        echo "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Timeless Memories Photography</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            color: #333;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f7f7f7;
        }

        .login-form {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #003366;
        }

        .login-form input {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f7f7f7;
        }

        .login-form button {
            width: 100%;
            padding: 15px;
            font-size: 1.2rem;
            background-color: #005e8c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-form button:hover {
            background-color: #003366;
        }

        .login-form p {
            text-align: center;
            margin-top: 15px;
        }

        .login-form p a {
            color: #005e8c;
            text-decoration: none;
        }

        .login-form p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Login Form -->
    <div class="login-container">
        <form class="login-form" action="login.php" method="POST">
            <h2>Admin Login</h2>
            
            <!-- Username Input -->
            <input type="text" name="username" placeholder="Username" required>

            <!-- Password Input -->
            <input type="password" name="password" placeholder="Password" required>

            <!-- Submit Button -->
            <button type="submit">Login</button>

            <!-- Error message if invalid login -->
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($error_message)) {
                echo "<p style='color: red; text-align: center;'>Invalid username or password.</p>";
            }
            ?>
            
            <!-- Link to Register (if applicable) -->
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </form>
    </div>

</body>
</html>
