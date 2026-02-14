<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$id = intval($_GET['id']);
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='$id'"));

if (!$user) {
    header("Location: users.php");
    exit;
}

if (isset($_POST['update'])) {
    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    mysqli_query($conn, "UPDATE users SET name='$name', email='$email' WHERE id='$id'");
    header("Location: users.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="container">
<div class="card" style="max-width:450px;margin:auto;">
<h2>Edit User</h2>

<form method="POST">
    <input type="text" name="name" value="<?= $user['name'] ?>" required>
    <input type="email" name="email" value="<?= $user['email'] ?>" required>
    <button name="update" class="btn">Update</button>
</form>

<a href="users.php">← Back</a>
</div>
</div>

</body>
</html>
