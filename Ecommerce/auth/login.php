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
<title>Login - MyShop</title>
<style>
    :root {
        --primary-color: #8B6F47;
        --secondary-color: #C17D51;
        --accent-color: #D4A574;
        --dark-color: #5D4E37;
        --light-color: #f8f9fa;
        --border-color: #dadce0;
        --shadow-2: 0 4px 16px rgba(0, 0, 0, 0.12);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
        box-sizing: border-box;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        background: linear-gradient(135deg, #8B6F47 0%, #A0826D 100%);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
        overflow: hidden;
        position: relative;
    }

    body::before {
        content: '';
        position: absolute;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        top: -100px;
        right: -100px;
    }

    body::after {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        bottom: -100px;
        left: -100px;
    }

    .login-container {
        background: white;
        padding: 50px;
        border-radius: 16px;
        box-shadow: var(--shadow-2);
        width: 100%;
        max-width: 400px;
        text-align: center;
        z-index: 10;
        animation: slideUp 0.5s ease;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .login-container h2 {
        margin: 0 0 10px 0;
        color: var(--dark-color);
        font-size: 28px;
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    .login-container > p {
        margin: 0 0 30px 0;
        color: #666;
        font-size: 14px;
        font-weight: 500;
        letter-spacing: 0.2px;
    }

    .login-container input {
        width: 100%;
        padding: 14px 16px;
        margin: 12px 0;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        outline: none;
        font-size: 14px;
        font-weight: 500;
        transition: var(--transition);
        font-family: inherit;
    }

    .login-container input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.1);
    }

    .login-container button {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, var(--primary-color), #6B5638);
        border: none;
        border-radius: 8px;
        color: white;
        font-size: 15px;
        font-weight: 700;
        letter-spacing: 0.3px;
        cursor: pointer;
        transition: var(--transition);
        margin-top: 10px;
        box-shadow: 0 2px 8px rgba(139, 111, 71, 0.3);
        text-transform: capitalize;
    }

    .login-container button:hover {
        background: linear-gradient(135deg, #6B5638, #4A3C28);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(139, 111, 71, 0.4);
    }

    .login-container button:active {
        transform: translateY(0);
    }

    .error {
        color: #d32f2f;
        margin: 15px 0;
        padding: 12px;
        background: #ffebee;
        border-radius: 8px;
        font-size: 14px;
        border-left: 4px solid #d32f2f;
    }

    a {
        text-decoration: none;
        color: var(--primary-color);
        display: block;
        margin-top: 15px;
        font-size: 14px;
        transition: var(--transition);
    }

    a:hover {
        color: #1565c0;
        text-decoration: underline;
    }

    .register-link {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid var(--border-color);
        font-size: 14px;
        color: #666;
    }

    .register-link a {
        margin: 5px 0 0 0;
        color: var(--primary-color);
        font-weight: 600;
    }
</style>
</head>
<body>
    <div class="login-container">
        <h2>Welcome Back</h2>
        <p>Login to your MyShop account</p>
        <?php if(isset($error)){ echo '<div class="error">'.$error.'</div>'; } ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <button name="login">Login</button>
        </form>
        <a href="forgot.php">Forgot Password?</a>
        <div class="register-link">
            Don't have an account? <a href="register.php">Create one</a>
        </div>
    </div>
</body>
</html>