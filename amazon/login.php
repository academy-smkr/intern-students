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
        $error = "You must accept the terms and conditions";
    } 
    else {
        $success = "Login successful";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login into your account</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(90deg, #fff, #6a6060);
        }
        
        header{
            text-align: center;
            padding: 20px;
        }

        #forms{
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        form {
            background-color: #fff;
            padding: 30px 35px;
            width: 360px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-size: 14px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        input:focus {
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.5);
            outline: none;
        }

        input[type="checkbox"] {
            margin-right: 6px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #667eea;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #5a6fdc;
        }

        .message {
            text-align: center;
            margin-top: 15px;
            font-weight: bold;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }

        a {
            color: #667eea;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h2>My Shop.in</h2>
    </header>
    
    <div id="forms">
        <form action="home2.php" method="post">
            <label for="user">Username :</label><br>
            <input type="text" name="user" id="user" value="<?php echo htmlspecialchars($user); ?>"><br><br>

            <label for="password">Password :</label><br>
            <input type="password" name="password" id="password"><br><br>

            <input type="checkbox" name="agree" id="agree" <?php if ($agree) echo "checked"; ?>>
            <label for="agree">I accept to the <a href="terms.txt">terms</a> and condtion</label><br><br>

            <input type="submit" name="submit">
            Don't have an account? <a href="register.php">Register</a>
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