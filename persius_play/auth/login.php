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
        $error = "Invalid Login";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
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
    .login-container {
        background: linear-gradient(135deg, rgba(179, 0, 255, 0.15) 0%, rgba(0, 255, 255, 0.10) 100%);
        padding: 48px 36px 36px 36px;
        border-radius: 0;
        box-shadow: 0 0 40px 8px #b300ff55, 0 0 0 2px #b300ff;
        width: 370px;
        text-align: center;
        border: 2px solid #b300ff;
        display: flex;
        flex-direction: column;
        align-items: stretch;
        gap: 0;
        margin-top: 40px;
        margin-bottom: 40px;
    }
    .login-container h2 {
        margin-bottom: 25px;
        color: #ff00ff;
        text-shadow: 0 0 16px #b300ff, 0 0 2px #00f5ff;
        letter-spacing: 2px;
    }
    .login-container input {
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
        text-align: left;
    }
    .login-container input:focus {
        border-color: #ff00ff;
        box-shadow: 0 0 8px #ff00ff55;
    }
    .login-container button {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #b300ff 0%, #ff006e 100%);
        border: none;
        border-radius: 0;
        color: #fff;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
        box-shadow: 0 0 20px #b300ff55;
        margin-top: 10px;
        text-shadow: 0 0 8px #ff00ff;
        display: block;
    }
    .login-container button:hover {
        background: linear-gradient(135deg, #ff006e 0%, #b300ff 100%);
        box-shadow: 0 0 30px #ff00ff99;
    }
    .error {
        color: #ff006e;
        margin-bottom: 15px;
        font-weight: bold;
        text-shadow: 0 0 8px #b300ff;
    }
    a {
        text-decoration: none;
        color: #00f5ff;
        display: block;
        margin-top: 15px;
        transition: 0.3s;
        font-weight: bold;
        text-shadow: 0 0 8px #00f5ff;
    }
    a:hover {
        color: #ff00ff;
        text-shadow: 0 0 12px #ff00ff;
    }
    .register-link {
        margin-top: 10px;
        font-size: 14px;
        color: #fff;
    }
</style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if(isset($error)){ echo '<div class="error">'.$error.'</div>'; } ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button name="login">Login</button>
        </form>
        <a href="forgot.php">Forgot Password?</a>
        <div class="register-link">
            Don't have an account? <a href="register.php">Register Here</a>
        </div>
    </div>
</body>
</html>
