<?php
session_start();

$phno = $user = "";
$agree = false;
$error = "";
$success = "";

if (isset($_POST["submit"])) {
    $phno = trim($_POST["phno"]);
    $user = trim($_POST["user"]);
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $agree = isset($_POST["agree"]);

    if (empty($phno)) {
        $error = "Phone number is required";
    } 
    elseif (!preg_match("/^[0-9]{10}$/", $phno)) {
        $error = "Phone number must be exactly 10 digits";
    } 
    elseif (empty($user)) {
        $error = "Username is required";
    } 
    elseif (!preg_match("/^[a-zA-Z0-9]+$/", $user)) {
        $error = "Username can contain only letters and numbers";
    } 
    elseif (empty($password)) {
        $error = "Password is required";
    } 
    elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters";
    } 
    elseif (empty($cpassword)) {
        $error = "Confirm password is required";
    } 
    elseif ($password !== $cpassword) {
        $error = "Passwords do not match";
    } 
    elseif (!$agree) {
        $error = "You must accept the terms and conditions";
    } 
    else {
        // Store registration details in session variables
        $_SESSION["registered_user"] = $user;
        $_SESSION["registered_phno"] = $phno;
        $_SESSION["registered_password"] = $password;
        $_SESSION["registered_date"] = date('Y-m-d H:i:s');
        $success = "✓ Registration successful! Redirecting to login page...";
        header("refresh:3; url=login.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Shoply</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Georgia', 'Courier New', serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #e8dcc8 0%, #d4c4b0 100%);
            background-image: repeating-linear-gradient(
                45deg,
                transparent,
                transparent 35px,
                rgba(0,0,0,.05) 35px,
                rgba(0,0,0,.05) 70px
            );
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        header {
            text-align: center;
            margin-bottom: 40px;
        }

        header h2 {
            font-size: 32px;
            color: #6b5b4c;
            letter-spacing: 2px;
            font-weight: 600;
            font-style: italic;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        #forms {
            display: flex;
            justify-content: center;
        }

        form {
            background-color: #f5e6d3;
            padding: 40px;
            width: 100%;
            max-width: 380px;
            border: 3px solid #9e8b7e;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        form:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        label {
            font-size: 13px;
            font-weight: 600;
            color: #6b5b4c;
            display: block;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 18px;
            border: 2px solid #9e8b7e;
            font-size: 14px;
            transition: all 0.3s ease;
            background-color: #fcf8f3;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #6b5b4c;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(107, 91, 76, 0.1);
            outline: none;
        }

        input[type="checkbox"] {
            margin-right: 8px;
            cursor: pointer;
        }

        input[type="checkbox"] + label {
            display: inline;
            margin-bottom: 0;
            text-transform: none;
            font-weight: normal;
            font-size: 13px;
            margin-bottom: 20px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #9e8b7e 0%, #8b7765 100%);
            color: #f5e6d3;
            border: 2px solid #6b5b4c;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.3s ease;
            letter-spacing: 1px;
        }

        input[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
            background: linear-gradient(135deg, #a67c52 0%, #9e8b7e 100%);
        }

        input[type="submit"]:active {
            transform: translateY(0);
        }

        .message {
            text-align: center;
            margin-top: 20px;
            font-weight: 600;
            padding: 12px;
            border: 2px solid;
        }

        .error {
            color: #8b4513;
            background-color: #f5deb3;
            border-color: #8b4513;
        }

        .success {
            color: #556b2f;
            background-color: #f0fff0;
            border-color: #556b2f;
        }

        a {
            color: #a67c52;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #8b6f47;
        }

        .login-link {
            text-align: center;
            margin-top: 18px;
            font-size: 13px;
            color: #8b7765;
        }
    </style>
</head>

<body>

<header>
    <h2>Shoply</h2>
</header>

<div id="forms">
    <form action="register.php" method="post">
        <label for="phno">Phone Number</label>
        <input type="text" name="phno" id="phno" placeholder="Enter 10-digit number" value="<?php echo htmlspecialchars($phno); ?>">

        <label for="user">Username</label>
        <input type="text" name="user" id="user" placeholder="Choose your username" value="<?php echo htmlspecialchars($user); ?>">

        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="At least 8 characters">

        <label for="cpassword">Confirm Password</label>
        <input type="password" name="cpassword" id="cpassword" placeholder="Re-enter your password">

        <input type="checkbox" name="agree" id="agree" <?php if ($agree) echo "checked"; ?>>
        <label for="agree">I accept the <a href="terms.txt">terms and conditions</a></label>

        <input type="submit" name="submit" value="Create Account">
        
        <div class="login-link">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </form>
</div>

<?php
if ($error) {
    echo "<p class='message error'>⚠ $error</p>";
} elseif ($success) {
    echo "<p class='message success'>✓ $success</p>";
}
?>

</body>
</html>
