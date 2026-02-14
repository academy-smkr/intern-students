<?php
session_start();
include "../config/db.php";

$msg = "";

if (isset($_POST['login'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass  = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM admins WHERE email='$email'");

    if (mysqli_num_rows($query) == 1) {
        $admin = mysqli_fetch_assoc($query);

        if (password_verify($pass, $admin['password'])) {
            $_SESSION['admin_id']   = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];

            header("Location: index.php");
            exit;
        } else {
            $msg = "Incorrect password!";
        }
    } else {
        $msg = "Admin account not found!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login | CampusFind</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="page-wrapper">
<div class="header">
    <h1>CampusFind – Admin Login</h1>
</div>

<div class="container">
    <div class="card" style="max-width:420px;margin:auto;">
        <h2>Admin Login</h2>

        <?php if ($msg) { ?>
            <p style="color:red;"><?php echo $msg; ?></p>
        <?php } ?>

        <form method="POST">
            <input type="email" name="email" placeholder="Admin Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit" name="login" class="btn">Login</button>
        </form>

        <p style="margin-top:12px;text-align:center;">
            Don’t have an account?
            <a href="register.php">Create Admin</a>
        </p>
    </div>
</div>

<div class="footer">
    © <?php echo date("Y"); ?> CampusFind | Admin Panel
</div>
</div>

</body>
</html>
