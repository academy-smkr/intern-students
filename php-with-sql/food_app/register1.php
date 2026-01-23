<?php
session_start();
include "config.php";

if (isset($_POST['register'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // check duplicate email
    $check = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $check);

    if (mysqli_num_rows($result) > 0) {
        echo "Email already registered";
    } else {
        $sql = "INSERT INTO users (name, email, password)
                VALUES ('$name', '$email', '$password')";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['success'] = "Registration successful. Please login.";
            header("Location: login.php");
            exit();
        }
    }
}
?>

<form method="POST">
Name: <input type="text" name="name" required><br><br>
Email: <input type="email" name="email" required><br><br>
Password: <input type="password" name="password" required><br><br>
<input type="submit" name="register" value="Register">
</form>