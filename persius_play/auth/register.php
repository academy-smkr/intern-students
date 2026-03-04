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
        font-family: 'Arial', 'Courier New', monospace;
        background: #0a0e27;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
    }
    .register-container {
        background: linear-gradient(135deg, rgba(179, 0, 255, 0.15) 0%, rgba(0, 255, 255, 0.10) 100%);
        padding: 36px 32px 28px 32px;
        border-radius: 0;
        box-shadow: 0 0 40px 8px #b300ff55, 0 0 0 2px #b300ff;
        width: 350px;
        text-align: center;
        border: 2px solid #b300ff;
        display: flex;
        flex-direction: column;
        align-items: stretch;
        gap: 0;
        margin: 0 auto;
    }
    .register-container h2 {
        margin-bottom: 25px;
        color: #ff00ff;
        text-shadow: 0 0 16px #b300ff, 0 0 2px #00f5ff;
        letter-spacing: 2px;
    }
    .register-container input {
        width: 90%;
        max-width: 320px;
        padding: 12px 18px;
        margin: 0 auto 18px auto;
        border: 1.5px solid #b300ff;
        border-radius: 0;
        outline: none;
        background: #181c3a;
        color: #fff;
        font-size: 15px;
        transition: 0.3s;
        box-shadow: 0 0 10px #b300ff22 inset;
        display: block;
        box-sizing: border-box;
        text-align: left;
    }
    .register-container input:focus {
        border-color: #ff00ff;
        box-shadow: 0 0 8px #ff00ff55;
    }
    .register-container button {
        width: 100%;
        padding: 12px 0;
        background: linear-gradient(135deg, #b300ff 0%, #ff006e 100%);
        border: none;
        border-radius: 0;
        color: #fff;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
        box-shadow: 0 0 20px #b300ff55;
        margin-top: 18px;
        margin-bottom: 18px;
        text-shadow: 0 0 8px #ff00ff;
        display: block;
        box-sizing: border-box;
    }
    .register-container button:hover {
        background: linear-gradient(135deg, #ff006e 0%, #b300ff 100%);
        box-shadow: 0 0 30px #ff00ff99;
    }
    .error {
        color: #ff006e;
        margin-bottom: 15px;
        font-weight: bold;
        text-shadow: 0 0 8px #b300ff;
    }
    .login-link {
        margin-top: 0;
        font-size: 14px;
        color: #fff;
        text-align: center;
        width: 100%;
        display: block;
    }
    .login-link a {
        text-decoration: none;
        color: #00f5ff;
        transition: 0.3s;
        font-weight: bold;
        text-shadow: 0 0 8px #00f5ff;
    }
    .login-link a:hover {
        color: #ff00ff;
        text-shadow: 0 0 12px #ff00ff;
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
