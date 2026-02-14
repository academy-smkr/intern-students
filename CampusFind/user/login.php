<?php
session_start();
include "../config/db.php";

$msg = "";

if (isset($_POST['login'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass  = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND status='active'");
    
    if (mysqli_num_rows($query) == 1) {
        $user = mysqli_fetch_assoc($query);

        if (password_verify($pass, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];

            header("Location: dashboard.php");
            exit;
        } else {
            $msg = "Incorrect password!";
        }
    } else {
        $msg = "Account not found or blocked!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Login | CampusFind</title>
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
    <div class="card" style="max-width:450px;margin:auto;">
        <h2>User Login</h2>

        <?php if ($msg != "") { ?>
            <p style="color:red;"><?php echo $msg; ?></p>
        <?php } ?>

        <form method="POST">
            <input type="email" name="email" placeholder="Registered Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit" name="login" class="btn">Login</button>
        </form>

        <p style="margin-top:15px;">
            New here?
            <a href="register.php">Create an account</a>
        </p>
    </div>
</div>

<div class="footer">
    © <?php echo date("Y"); ?> CampusFind
</div>
</div>
</body>
</html>
