<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$uid = $_SESSION['user_id'];
echo "Welcome " . $_SESSION['user_name'] . "<br><br>";

// Insert food order
if (isset($_POST['order'])) {

    $food = $_POST['food'];
    $qty = $_POST['qty'];
    $uid = $_SESSION['user_id'];

    $sql = "INSERT INTO orders (user_id, food_name, quantity)
            VALUES ('$uid', '$food', '$qty')";
    mysqli_query($conn, $sql);
}

// Select orders
$result = mysqli_query($conn, "SELECT * FROM orders WHERE user_id='$uid'");
?>

<form method="POST">
Food Name: <input type="text" name="food" required>
Quantity: <input type="number" name="qty" required>
<input type="submit" name="order" value="Order Food">
</form>

<h3>Your Orders</h3>
<?php
while ($row = mysqli_fetch_assoc($result)) {
    echo $row['food_name'] . " - " . $row['quantity'] . "<br>";
}
?>

<br>
<a href="logout.php">Logout</a>