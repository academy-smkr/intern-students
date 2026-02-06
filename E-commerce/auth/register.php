<?php
session_start();
include '../config/db.php';

if(isset($_POST['register'])){
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if($password !== $confirm_password){
        $error = "Passwords do not match!";
    } else {
        $pass_hashed = password_hash($password, PASSWORD_BCRYPT);

        mysqli_query($conn,"INSERT INTO users(name,email,password) 
        VALUES('$name','$email','$pass_hashed')");

        header("Location: login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>
<style>
    body {
        font-family: 'Arial', sans-serif;
        background: linear-gradient(to right, #6a11cb, #2575fc);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
    }

    .register-container {
        background: #fff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        width: 350px;
        text-align: center;
    }

    .register-container h2 {
        margin-bottom: 25px;
        color: #333;
    }

    .register-container input {
        width: 100%;
        padding: 12px 15px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 8px;
        outline: none;
        transition: 0.3s;
    }

    .register-container input:focus {
        border-color: #2575fc;
        box-shadow: 0 0 5px rgba(37,117,252,0.5);
    }

    .register-container button {
        width: 100%;
        padding: 12px;
        background: #2575fc;
        border: none;
        border-radius: 8px;
        color: #fff;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s;
    }

    .register-container button:hover {
        background: #6a11cb;
    }

    .error {
        color: red;
        margin-bottom: 15px;
    }

    .login-link {
        margin-top: 15px;
        font-size: 14px;
    }

    .login-link a {
        text-decoration: none;
        color: #2575fc;
        transition: 0.3s;
    }

    .login-link a:hover {
        color: #6a11cb;
    }
</style>
</head>
<body>
    <div class="register-container">
        <h2>Register</h2>
        <?php if(isset($error)){ echo '<div class="error">'.$error.'</div>'; } ?>
        <form method="POST">
            <input type="text" name="name" required placeholder="Name">
            <input type="email" name="email" required placeholder="Email">
            <input type="password" name="password" required placeholder="Password">
            <input type="password" name="confirm_password" required placeholder="Confirm Password">
            <button name="register">Register</button>
        </form>
        <div class="login-link">
            Already have an account? <a href="login.php">Login Here</a>
        </div>
    </div>
</body>
</html>
