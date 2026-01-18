<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile Page</title>
</head>
<body>
    <h2>User Profile</h2>

    <?php
    if(isset($_SESSION["user"])){
        echo "Logged in user: " . $_SESSION["user"];
    }
    else{
        echo "No user is logged in";
    }
    ?>

    <br><br>

    <a href="logout.php">Logout</a>
</body>
</html>