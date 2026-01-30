<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Cart</title>
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

<h2>My Cart</h2>

<ul>
<?php
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        echo "<li>$item</li>";
    }
} else {
    echo "Cart is empty <br><br>";
}
?>
</ul>

<a href="home2.php">Go back</a>

</body>
</html>
