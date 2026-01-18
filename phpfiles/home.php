<?php
session_start();
$_SESSION["user"] = $_POST["username"]; //store the username in session
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home Page</title>
</head>
<body>
    <h2>Welcome</h2>

    <?php
    echo "Hello," . $_SESSION["user"];
    ?>

    <br><br>

    <a href="profile.php">Go to profile page</a>
</body>
</html>