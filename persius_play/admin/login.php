<?php
session_start();
include '../config/db.php'; // Adjust path

$message = '';
if(isset($_SESSION['success'])){
    $message = $_SESSION['success'];
    unset($_SESSION['success']);
}

if(isset($_POST['login'])){
    $email = trim($_POST['email']);
    $pass  = $_POST['password'];

    // Fetch admin by email
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if($admin && password_verify($pass, $admin['password'])){
        $_SESSION['admin'] = $admin['id'];
        header("Location: index.php"); // Admin dashboard
        exit();
    } else {
        $message = "Invalid email or password!";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; }
        .container { max-width: 400px; margin: 100px auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px #ccc; }
        h2 { text-align: center; margin-bottom: 20px; }
        input[type=email], input[type=password] { width: 100%; padding: 10px; margin: 5px 0 15px; border-radius: 4px; border: 1px solid #ccc; }
        button { width: 100%; padding: 10px; background: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #495057; }
        .message { color: red; text-align: center; margin-bottom: 15px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Admin Login</h2>
    <?php if($message != '') { echo '<div class="message">'.$message.'</div>'; } ?>
    <form method="POST" action="">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>
    <p style="text-align:center; margin-top:10px;">Not registered? <a href="register.php">Register here</a></p>
</div>
</body>
</html>
