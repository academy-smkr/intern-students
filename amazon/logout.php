<?php
session_start();

session_unset();  

session_destroy();  

echo "You are logged out";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Logout</title>
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
    <a href="home.php">Go back</a>
</body>
</html>