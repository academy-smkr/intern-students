<?php
session_start(); 

$user = "";
$agree = false;
$error = "";
$success = "";

if (isset($_POST["submit"])) {
    $user = trim($_POST["user"]);
    $password = $_POST["password"];
    $agree = isset($_POST["agree"]);

    if (empty($user)){
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
    elseif (!$agree) {
        $error = "Please check 'Keep me logged in' to continue";
    } 
    else {
        // Check credentials against registered session variables
        if (isset($_SESSION["registered_user"]) && 
            $_SESSION["registered_user"] === $user && 
            $_SESSION["registered_password"] === $password) {
            // Valid credentials - set login session
            $_SESSION["user"] = $user;
            $_SESSION["phno"] = $_SESSION["registered_phno"];
            $_SESSION["is_logged_in"] = true;
            $success = "Login successful! Redirecting...";
            header("refresh:2; url=home.php");
        } else {
            $error = "Invalid username or password";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login into your account</title>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&family=Verdana&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Verdana', 'Arial', sans-serif;
        }

        body {
            min-height: 100vh;
            background-color: #000000;
            background-image: 
                linear-gradient(45deg, #1a1a1a 25%, transparent 25%),
                linear-gradient(-45deg, #1a1a1a 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #1a1a1a 75%),
                linear-gradient(-45deg, transparent 75%, #1a1a1a 75%);
            background-size: 40px 40px;
            background-position: 0 0, 0 20px, 20px -20px, -20px 0px;
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
            color: #E8E8E8;
            letter-spacing: 2px;
            font-weight: 700;
            font-style: normal;
            text-transform: lowercase;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
            font-family: 'Anton', sans-serif;
        }

        #forms {
            display: flex;
            justify-content: center;
        }

        form {
            background: linear-gradient(135deg, #2a2a2a 0%, #1a1a1a 100%);
            padding: 40px;
            width: 100%;
            max-width: 380px;
            border: 2px solid #A8A8A8;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.8), inset 0 1px 0px rgba(192, 192, 192, 0.3);
            transition: all 0.2s ease;
            border-top: 1px solid #E8E8E8;
        }

        form:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.9), inset 0 1px 0px rgba(192, 192, 192, 0.4), 0 0 12px rgba(192, 192, 192, 0.2);
        }

        label {
            font-size: 12px;
            font-weight: 600;
            color: #E8E8E8;
            display: block;
            margin-bottom: 8px;
            text-transform: lowercase;
            letter-spacing: 0.5px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 18px;
            border: 1px solid #808080;
            border-top: 1px solid #606060;
            border-left: 1px solid #606060;
            font-size: 13px;
            transition: all 0.2s ease;
            background-color: #1a1a1a;
            color: #000000ff;
            font-weight: 500;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.7);
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #C0C0C0;
            background-color: #252525;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.7), 0 0 8px rgba(192, 192, 192, 0.3);
            outline: none;
        }

        input[type="checkbox"] {
            margin-right: 8px;
            cursor: pointer;
            accent-color: #A8A8A8;
        }

        input[type="checkbox"] + label {
            display: inline;
            margin-bottom: 0;
            text-transform: none;
            font-weight: normal;
            font-size: 12px;
            margin-bottom: 20px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 11px;
            background: linear-gradient(180deg, #D3D3D3 0%, #A8A8A8 100%);
            color: #000000;
            border: 2px solid #808080;
            border-top: 1px solid #FFFFFF;
            border-left: 1px solid #FFFFFF;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.15s ease;
            letter-spacing: 0.5px;
            text-transform: lowercase;
            box-shadow: inset 0 1px 0px rgba(255, 255, 255, 0.6), 0 2px 4px rgba(0, 0, 0, 0.6);
        }

        input[type="submit"]:hover {
            background: linear-gradient(180deg, #000000ff 0%, #C0C0C0 100%);
            transform: translateY(-1px);
            box-shadow: inset 0 1px 0px rgba(255, 255, 255, 0.8), 0 4px 8px rgba(0, 0, 0, 0.7);
        }

        input[type="submit"]:active {
            transform: translateY(0);
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.6);
        }

        .message {
            text-align: center;
            margin-top: 20px;
            font-weight: 600;
            padding: 12px;
            border: 2px solid;
            text-transform: lowercase;
            letter-spacing: 0.5px;
        }

        .error {
            color: #000000;
            background-color: #A8A8A8;
            border-color: #606060;
        }

        .success {
            color: #000000;
            background-color: #C0C0C0;
            border-color: #808080;
        }

        a {
            color: #E8E8E8;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        a:hover {
            color: #FFFFFF;
        }

        .login-link {
            text-align: center;
            margin-top: 18px;
            font-size: 12px;
            color: #E8E8E8;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <header>
        <h2>Batte Angadi</h2>
    </header>
    
    <div id="forms">
        <form action="login.php" method="post">
            <label for="user">Username :</label><br>
            <input type="text" name="user" id="user" value="<?php echo htmlspecialchars($user); ?>"><br><br>

            <label for="password">Password :</label><br>
            <input type="password" name="password" id="password"><br><br>

            <input type="checkbox" name="agree" id="agree" <?php if ($agree) echo "checked"; ?>>
            <label for="agree">Keep me logged in</label><br><br>

            <input type="submit" name="submit" value="Login">
            <div class="login-link">Don't have an account? <a href="register.php">Register</a></div>
        </form>
    </div>

<?php
if ($error) {
    echo "<p class='message error'>$error</p>";
} elseif ($success) {
    echo "<p class='message success'>$success</p>";
}
?>
</body>
</html>