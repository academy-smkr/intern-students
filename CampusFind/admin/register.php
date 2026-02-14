<?php
session_start();
include "../config/db.php";

$msg = "";

if (isset($_POST['register'])) {
    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass  = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT * FROM admins WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $msg = "Admin already exists!";
    } else {
        mysqli_query($conn, "
            INSERT INTO admins (name, email, password)
            VALUES ('$name','$email','$pass')
        ");
        $msg = "Admin registered successfully!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Register | CampusFind</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="page-wrapper">
<div class="header">
    <h1>CampusFind – Admin Registration</h1>
</div>

<div class="container">
    <div class="card" style="max-width:420px;margin:auto;">
        <h2>Create Admin</h2>

        <?php if ($msg) { ?>
            <p style="color:green;"><?php echo $msg; ?></p>
        <?php } ?>

        <form method="POST">
            <input type="text" name="name" placeholder="Admin Name" required>
            <input type="email" name="email" placeholder="Admin Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit" name="register" class="btn">Register</button>
        </form>

        <p style="margin-top:12px;text-align:center;">
            Already have an account?
            <a href="login.php">Login</a>
        </p>
    </div>
</div>

<div class="footer">
    © <?php echo date("Y"); ?> CampusFind | Admin Panel
</div>
</div>

</body>
</html>
