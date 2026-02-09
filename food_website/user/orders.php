<?php include "../db.php"; include "../header.php"; ?>
<?php

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}
?>

<h2>My Orders</h2>

<?php
$q=mysqli_query($conn,
"SELECT * FROM orders WHERE user_id='$_SESSION[user_id]'");
while($o=mysqli_fetch_assoc($q)){
    echo "Order #".$o['id']." | Total: ".$o['total_price'].
         " | ".$o['payment_method']." | ".$o['order_date']."<br>";
}
?>