<?php
session_start();
include "../config/db.php";

$msg = "";

if (isset($_POST['register'])) {

    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass  = $_POST['password'];

    // Check if email already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $msg = "Email already registered!";
    } else {
        $hashed = password_hash($pass, PASSWORD_DEFAULT);

        $insert = mysqli_query($conn, 
            "INSERT INTO users (name,email,password) 
             VALUES ('$name','$email','$hashed')"
        );

        if ($insert) {
            header("Location: login.php");
            exit;
        } else {
            $msg = "Registration failed. Try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Registration | CampusFind</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="page-wrapper">
    
<div class="header">
    <div style="display:flex;align-items:center;gap:15px;">
        <img src="../assets/images/college-logo.png">
        <h1>CampusFind</h1>
    </div>
</div>

<div class="container">
    <div class="card" style="max-width:500px;margin:auto;">
        <h2>User Registration</h2>

        <?php if ($msg != "") { ?>
            <p style="color:red;"><?php echo $msg; ?></p>
        <?php } ?>

        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit" name="register" class="btn">Register</button>
        </form>

        <p style="margin-top:15px;">
            Already have an account?
            <a href="login.php">Login here</a>
        </p>
    </div>
</div>

<div class="footer">
    © <?php echo date("Y"); ?> CampusFind
</div>
</div>
</body>
</html>
