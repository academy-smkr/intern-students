<?php include "../db.php"; include "../header.php"; ?>
<?php

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
}
?>

<h2>All Orders</h2>

<?php
$q=mysqli_query($conn,
"SELECT users.name,orders.total_price,orders.payment_method,orders.order_date
 FROM orders
 JOIN users ON orders.user_id=users.id");

while($o=mysqli_fetch_assoc($q)){
    echo "User: ".$o['name']." | Total: ".$o['total_price'].
         " | Payment: ".$o['payment_method']." | Date: ".$o['order_date']."<br>";
}
?>