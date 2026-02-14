<?php
session_start();
include '../config/db.php';

if(isset($_POST['login'])){
    $email=$_POST['email'];
    $pass=$_POST['password'];

    $q = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
    $u = mysqli_fetch_assoc($q);

    if($u && password_verify($pass,$u['password'])){
        $_SESSION['user']=$u['id'];
        header("Location: ../index.php");
        exit;
    }else{
        $error = "Invalid login details";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pet Parent Login - PawMart</title>
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

    .login-container {
        background: #fff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        width: 350px;
        text-align: center;
    }

    .login-container h2 {
        margin-bottom: 25px;
        color: #203036;
    }

    .login-container input {
        width: 100%;
        padding: 12px 15px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 8px;
        outline: none;
        transition: 0.3s;
    }

    .login-container input:focus {
        border-color: #1f6f5f;
        box-shadow: 0 0 5px rgba(31,111,95,0.4);
    }

    .login-container button {
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

    .login-container button:hover {
        background: #1a5b4f;
    }

    .error {
        color: red;
        margin-bottom: 15px;
    }

    a {
        text-decoration: none;
        color: #1f6f5f;
        display: block;
        margin-top: 15px;
        transition: 0.3s;
    }

    a:hover {
        color: #ff7a2f;
    }

    .register-link {
        margin-top: 10px;
        font-size: 14px;
    }
</style>
</head>
<body>
    <div class="login-container">
        <h2>Pet Parent Login</h2>
        <?php if(isset($error)){ echo '<div class="error">'.$error.'</div>'; } ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button name="login">Login</button>
        </form>
        <a href="forgot.php">Forgot Password?</a>
        <div class="register-link">
            New to PawMart? <a href="register.php">Create an Account</a>
        </div>
    </div>
</body>
</html>
