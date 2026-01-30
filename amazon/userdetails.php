<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>profile</title>
    <style>
        body {
            font-family: Arial;
            background: #333;
            padding: 40px;
            color: white;
        }

        a {
            color: yellow;
        }
    </style>
</head>
<body>
    <h2>Profile</h2>

    <?php
    if(isset($_SESSION["user"])){
        echo "Username :" . $_SESSION["user"] . "<br><br>";
        echo "Phone Number :" . $_SESSION["phno"] . "<br><br>";
    }
    else{
        echo "No user is logged in";
    }
    ?>

    <a href="home2.php">Go back</a>
</body>
</html>