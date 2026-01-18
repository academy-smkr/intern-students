<?php
session_start(); //start session
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login page</title>
</head>
<body>
    <h2>Login</h2>

    <form action="home.php" method="post">
        Enter Name:
        <input type="text" name="username" required><br><br>
        <input type="submit" name="submit" value="login">
    </form>
</body>
</html>