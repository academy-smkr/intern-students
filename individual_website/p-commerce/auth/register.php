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
<title>Create Account - PawMart</title>
<style>
    body {
        font-family: 'Nunito', Arial, sans-serif;
        background: linear-gradient(120deg, #1f6f5f, #ff7a2f);
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
        color: #203036;
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
        border-color: #1f6f5f;
        box-shadow: 0 0 5px rgba(31,111,95,0.4);
    }

    .register-container button {
        width: 100%;
        padding: 12px;
        background: #1f6f5f;
        border: none;
        border-radius: 8px;
        color: #fff;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s;
    }

    .register-container button:hover {
        background: #1a5b4f;
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
        color: #1f6f5f;
        transition: 0.3s;
    }

    .login-link a:hover {
        color: #ff7a2f;
    }
</style>
</head>
<body>
    <div class="register-container">
        <h2>Create Pet Parent Account</h2>
        <?php if(isset($error)){ echo '<div class="error">'.$error.'</div>'; } ?>
        <form method="POST">
            <input type="text" name="name" required placeholder="Full Name">
            <input type="email" name="email" required placeholder="Email">
            <input type="password" name="password" required placeholder="Password">
            <input type="password" name="confirm_password" required placeholder="Confirm Password">
            <button name="register">Create Account</button>
        </form>
        <div class="login-link">
            Already have an account? <a href="login.php">Login Here</a>
        </div>
    </div>
</body>
</html>
