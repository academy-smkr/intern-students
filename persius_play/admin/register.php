<?php
session_start();
include '../config/db.php'; // Adjust path to your db.php

$message = '';

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Basic validation
    if (empty($username) || empty($email) || empty($password)) {
        $message = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format!";
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match!";
    } else {
        // Check if username or email already exists
        $stmt = $conn->prepare("SELECT id FROM admin WHERE username=? OR email=?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "Username or Email already exists!";
        } else {
            // Hash password before storing
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO admin (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                // Registration successful, redirect to login
                $_SESSION['success'] = "Admin registered successfully! You can login now.";
                header("Location: login.php");
                exit();
            } else {
                $message = "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Registration</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; }
        .container { max-width: 400px; margin: 50px auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px #ccc; }
        h2 { text-align: center; margin-bottom: 20px; }
        input[type=text], input[type=email], input[type=password] { width: 100%; padding: 10px; margin: 5px 0 15px; border-radius: 4px; border: 1px solid #ccc; }
        input[type=submit] { width: 100%; padding: 10px; background: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; }
        input[type=submit]:hover { background: #495057; }
        .message { color: red; text-align: center; margin-bottom: 15px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Admin Registration</h2>
    <?php if($message != '') { echo '<div class="message">'.$message.'</div>'; } ?>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <input type="submit" name="register" value="Register">
    </form>
    <p style="text-align:center; margin-top:10px;">Already registered? <a href="login.php">Login here</a></p>
</div>
</body>
</html>
