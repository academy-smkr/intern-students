<?php
session_start();
include "config.php";


if (isset($_SESSION['success'])) {
    echo $_SESSION['success'] . "<br><br>";
    unset($_SESSION['success']);
}

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users 
            WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        header("Location: home.php");
        exit();
    } else {
        echo "Invalid login";
    }
}
?>

<form method="POST">
Email: <input type="email" name="email" required><br><br>
Password: <input type="password" name="password" required><br><br>
<input type="submit" name="login" value="Login"><br><br>
<a href="register1.php">Did not register before?</a>
</form>